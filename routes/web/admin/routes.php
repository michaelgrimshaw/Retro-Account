<?php

use Illuminate\Routing\Router;

$router->group(['as' => 'admin.', 'domain' => env('ADMIN_URL')], function (Router $router) {

});
