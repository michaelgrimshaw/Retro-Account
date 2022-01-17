<?php

namespace Tests\Feature\Portal;

use App\Account\Models\Account;
use Illuminate\Auth\Access\AuthorizationException;
use Tests\Traits\AutoLoginTrait;
use Tests\TestCase;
use Tests\Traits\InteractsWithPermissions;

/**
 * Class PortalTestCase
 *
 * @package Tests\Feature\Portal
 */
abstract class PortalTestCase extends TestCase
{
    use AutoLoginTrait,
        InteractsWithPermissions;

    /**
     * {@inheritdoc}
     */
    public function expectException(string $exception): void
    {
        $this->disableExceptionHandling();

        parent::expectException($exception);
    }

    /**
     * Expect an AuthorizationException to be thrown
     *
     * @return $this
     */
    protected function expectAuthorizationException()
    {
        $this->expectException(AuthorizationException::class);

        return $this;
    }
}
