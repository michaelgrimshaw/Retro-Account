<?php

namespace Tests\Feature\Portal\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\Portal\PortalTestCase;

class AccountIndexTest extends PortalTestCase
{
    use DatabaseMigrations;


    /** @test */
    public function the_accounts_index_view_loads_correctly()
    {
        $response = $this->get(route('portal.account.index'));

        $response->assertStatus(200)
            ->assertSee('Welcome,');
    }

    /** @test */
    public function the_user_must_be_authorised_to_view_accounts()
    {
        $this->expectAuthorizationException();
        $this->denyPermission('account.read');

        $this->get(route('portal.account.index'));
    }
}
