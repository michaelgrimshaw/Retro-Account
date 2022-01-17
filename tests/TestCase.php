<?php

namespace Tests;

use App\Core\Exceptions\Handler;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\ConfiguresTraits;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        ConfiguresTraits;

    /**
     * Disable Laravel's default exception handler and throw the exception
     *
     * @return void
     */
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class($this->app) extends Handler {
            public function __construct(Container $container) {}
            public function report(Throwable $e) {}
            public function render($request, Throwable $e) {
                throw $e;
            }
        });
    }
}
