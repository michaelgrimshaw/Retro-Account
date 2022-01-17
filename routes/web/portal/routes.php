<?php

use Illuminate\Routing\Router;

$router->group(['middleware' => 'portal', 'as' => 'portal.', 'domain' => env('APP_URL')], function (Router $router) {
    require "account.php";
});
