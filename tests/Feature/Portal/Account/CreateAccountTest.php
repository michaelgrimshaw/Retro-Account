<?php

namespace Tests\Feature\Portal\Account;

use App\Account\Models\Account;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\Portal\PortalTestCase;

class CreateAccountTest extends PortalTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function the_account_create_view_loads_correctly()
    {
        // Arrange
        $this->disableExceptionHandling();

        // Act
        $response = $this->get(route('portal.account.create'));

        // Assert
        $response->assertStatus(200)
            ->assertSee('Create your account');
    }

    /** @test */
    public function only_authorised_users_can_view_the_create_account_screen()
    {
        // Arrange
        $this->expectAuthorizationException()
            ->denyPermission('account.create');

        // Act
        $this->get(route('portal.account.create'));
    }

    /** @test */
    public function only_authorised_users_can_store_a_new_account()
    {
        // Arrange
        $this->expectAuthorizationException()
            ->denyPermission('account.create');

        // Act
        $this->post(route('portal.account.store'), $this->validCreateData());
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
            $this->post(route('portal.account.store'), [
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

        $this->fail("Failed to check that the accounts {$field} was required on store.");
    }

    public function requiredFields()
    {
        return [
            ['name'],
            ['goal'],
            ['balance'],
        ];
    }

    /** @test */
    function a_new_account_can_be_created_when_valid_fields_are_submitted()
    {
        // Arrange
        $this->assertCount(0, Account::all());

        // Act
        $this->post(route('portal.account.store'), $this->validCreateData());

        // Assert
        $this->assertCount(1, Account::all());
    }

    /** @test */
    function the_user_is_redirected_to_the_edit_view_once_a_new_account_is_created()
    {
        // Arrange
        $this->assertCount(0, Account::all());

        // Act
        $response = $this->post(route('portal.account.store'), $this->validCreateData());

        // Assert
        $response->assertRedirect(route('portal.account.show', Account::first()->reference));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function validCreateData($params = []): array
    {
        return array_merge(
            Account::factory()->make()->toArray(),
            $params
        );
    }
}
