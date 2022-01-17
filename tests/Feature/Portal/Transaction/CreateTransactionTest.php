<?php

namespace Tests\Feature\Portal\Transaction;

use App\Account\Models\Account;
use App\Transaction\Models\Transaction;
use App\Transaction\Models\TransactionType;
use App\Transaction\Rules\Overdraft;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\Portal\PortalTestCase;

class CreateTransactionTest extends PortalTestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Account\Models\Account|null
     */
    public $account = null;

    /**
     * Test setup hook
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed('TransactionTypeSeeder');

        $this->account = Account::factory()->create();
    }

    /** @test */
    public function the_transaction_create_view_loads_correctly()
    {
        // Arrange
        $this->disableExceptionHandling();

        // Act
        $response = $this->get(route('portal.account.transaction.create', $this->account));

        // Assert
        $response->assertStatus(200)
            ->assertSee('Make a transaction');
    }

    /** @test */
    public function only_authorised_users_can_view_the_create_transaction_screen()
    {
        // Arrange
        $this->expectAuthorizationException()
            ->denyPermission('transaction.create');

        // Act
        $this->get(route('portal.account.transaction.create', $this->account));
    }

    /** @test */
    public function only_authorised_users_can_store_a_new_transaction()
    {
        // Arrange
        $this->expectAuthorizationException()
            ->denyPermission('transaction.create');

        // Act
        $this->post(route('portal.account.transaction.store', $this->account), $this->validCreateData(['transaction_date' => Carbon::now()->format('Y-m-d')]));
    }

    /**
     * @test
     * @dataProvider requiredFields
     */
    function the_required_fields_are_validated($field)
    {
        // Arrange
        $this->disableExceptionHandling();

        // Act
        try {
            $this->post(route('portal.account.transaction.store', $this->account), [
                $field => ''
            ]);
        }

            // Assert
        catch (ValidationException $e) {
            $failed = $e->validator->failed();
            $this->assertTrue(in_array($field, array_keys($failed)), "No validation errors thrown for the {$field} field.");
            $this->assertTrue(in_array('Required', array_keys($failed[$field])), "No validation errors thrown for {$field}.required");
            return;
        }

        $this->fail("Failed to check that the transactions {$field} was required on store.");
    }

    public function requiredFields()
    {
        return [
            ['transaction_type_id'],
            ['transaction_date'],
            ['description'],
            ['value'],
        ];
    }

    /** @test */
    function a_new_transaction_can_be_created_when_valid_fields_are_submitted()
    {
        // Arrange
        $this->assertCount(0, Transaction::all());

        // Act
        $this->post(route('portal.account.transaction.store', $this->account), $this->validCreateData(['transaction_date' => Carbon::now()->format('Y-m-d')]));

        // Assert
        $this->assertCount(1, Transaction::all());
    }

    /** @test */
    function the_user_is_redirected_to_the_edit_view_once_a_new_transaction_is_created()
    {
        // Arrange
        $this->assertCount(0, Transaction::all());

        // Act
        $response = $this->post(route('portal.account.transaction.store', $this->account), $this->validCreateData(['transaction_date' => Carbon::now()->format('Y-m-d')]));

        // Assert
        $response->assertRedirect(route('portal.account.show', $this->account));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function validCreateData($params = []): array
    {
        return array_merge(
            Transaction::factory()->for($this->account)->make()->toArray(),
            $params
        );
    }
}
