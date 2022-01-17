<?php

use App\Account\Http\Portal\Controllers\AccountController;

use App\Transaction\Http\Portal\Controllers\TransactionController;
use Illuminate\Routing\Router;

$router->group(['as' => 'account.'], function (Router $router) {
    $router->get('/')->name('index')->uses([AccountController::class, 'index']);
    $router->get('create')->name('create')->uses([AccountController::class, 'create']);
    $router->post('/')->name('store')->uses([AccountController::class, 'store']);

    $router->group(['prefix' => '{account:reference}'], function (Router $router) {
        $router->get('/')->name('show')->uses([AccountController::class, 'show']);
        $router->group(['as' => 'transaction.'], function (Router $router) {
            $router->get('transaction')->name('create')->uses([TransactionController::class, 'create']);
            $router->post('/')->name('store')->uses([TransactionController::class, 'store']);
        });
    });
});
