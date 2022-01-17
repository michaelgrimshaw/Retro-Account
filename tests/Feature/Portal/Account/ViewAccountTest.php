<?php

namespace Tests\Feature\Portal\Account;

use App\Account\Models\Account;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\Portal\PortalTestCase;

class ViewAccountTest extends PortalTestCase
{
    use DatabaseMigrations;


    /** @test */
    public function the_view_account_view_loads_correctly()
    {
        $account = Account::factory()->for($this->actor)->create();

        $response = $this->get(route('portal.account.show', $account));

        $response->assertStatus(200)
            ->assertSee($account->first_name);
    }

    /** @test */
    public function a_404_is_thrown_if_the_account_is_not_found()
    {
        // Act
        $response = $this->get(route('portal.account.show', 99));

        // Assert
        $response->assertStatus(404);
    }

    /** @test */
    public function the_user_must_be_authorised_to_view_a_account()
    {
        $this->expectAuthorizationException();
        $this->denyPermission('account.read');

        $account = Account::factory()->create();

        $this->get(route('portal.account.show', $account));
    }
}
