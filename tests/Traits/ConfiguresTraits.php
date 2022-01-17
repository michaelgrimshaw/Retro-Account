<?php

namespace Tests\Traits;

/**
 * Trait ConfiguresTraits
 *
 * @package Tests\Traits
 */
trait ConfiguresTraits
{
    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[InteractsWithPermissions::class])) {
            $this->setupInteractsWithPermissionsTrait();
        }

        return $uses;
    }
}
