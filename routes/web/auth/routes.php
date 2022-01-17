<?php

use Illuminate\Routing\Router;

$router->group(['as' => 'admin.', 'domain' => env('ADMIN_URL')], function (Router $router) {
    $router->get('/register')->middleware('guest')->name('register')->uses([\App\Auth\Http\Admin\Controllers\RegisteredUserController::class, 'create']);
    $router->post('/register')->middleware('guest')->uses([\App\Auth\Http\Admin\Controllers\RegisteredUserController::class, 'store']);

    $router->get('/login')->middleware('guest')->name('login')->uses([\App\Auth\Http\Admin\Controllers\AuthenticatedSessionController::class, 'create']);
    $router->post('/login')->middleware('guest')->uses([\App\Auth\Http\Admin\Controllers\AuthenticatedSessionController::class, 'store']);

    $router->get('/forgot-password')->middleware('guest')->name('password.request')->uses([\App\Auth\Http\Admin\Controllers\PasswordResetLinkController::class, 'create']);
    $router->post('/forgot-password')->middleware('guest')->name('password.email')->uses([\App\Auth\Http\Admin\Controllers\PasswordResetLinkController::class, 'store']);

    $router->get('/reset-password/{token}')->middleware('guest')->name('password.reset')->uses([\App\Auth\Http\Admin\Controllers\NewPasswordController::class, 'create']);
    $router->post('/reset-password')->middleware('guest')->name('password.update')->uses([\App\Auth\Http\Admin\Controllers\NewPasswordController::class, 'store']);

    $router->get('/verify-email')->middleware('auth')->name('verification.notice')->uses([\App\Auth\Http\Admin\Controllers\EmailVerificationNotificationController::class, '__invoke']);
    $router->get('/verify-email/{id}/{hash}')->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify')->uses([\App\Auth\Http\Admin\Controllers\VerifyEmailController::class, '__invoke']);
    $router->post('/email/verification-notification')->middleware(['auth', 'throttle:6,1'])->name('verification.send')->uses([\App\Auth\Http\Admin\Controllers\EmailVerificationNotificationController::class, 'store']);

    $router->get('/confirm-password')->middleware('auth')->name('password.confirm')->uses([\App\Auth\Http\Admin\Controllers\ConfirmablePasswordController::class, 'show']);
    $router->post('/confirm-password')->middleware('auth')->name('password.confirm')->uses([\App\Auth\Http\Admin\Controllers\ConfirmablePasswordController::class, 'store']);

    $router->get('/logout')->middleware('auth')->name('logout')->uses([\App\Auth\Http\Admin\Controllers\AuthenticatedSessionController::class, 'destroy']);
});

$router->group(['as' => 'portal.', 'domain' => env('APP_URL')], function (Router $router) {
    $router->get('/register')->middleware('guest')->name('register')->uses([\App\Auth\Http\Portal\Controllers\RegisteredUserController::class, 'create']);
    $router->post('/register')->middleware('guest')->uses([\App\Auth\Http\Portal\Controllers\RegisteredUserController::class, 'store']);

    $router->get('/login')->middleware('guest')->name('login')->uses([\App\Auth\Http\Portal\Controllers\AuthenticatedSessionController::class, 'create']);
    $router->post('/login')->middleware('guest')->uses([\App\Auth\Http\Portal\Controllers\AuthenticatedSessionController::class, 'store']);

    $router->get('/forgot-password')->middleware('guest')->name('password.request')->uses([\App\Auth\Http\Portal\Controllers\PasswordResetLinkController::class, 'create']);
    $router->post('/forgot-password')->middleware('guest')->name('password.email')->uses([\App\Auth\Http\Portal\Controllers\PasswordResetLinkController::class, 'store']);

    $router->get('/reset-password/{token}')->middleware('guest')->name('password.reset')->uses([\App\Auth\Http\Portal\Controllers\NewPasswordController::class, 'create']);
    $router->post('/reset-password')->middleware('guest')->name('password.update')->uses([\App\Auth\Http\Portal\Controllers\NewPasswordController::class, 'store']);

    $router->get('/verify-email')->middleware('auth')->name('verification.notice')->uses([\App\Auth\Http\Portal\Controllers\EmailVerificationNotificationController::class, '__invoke']);
    $router->get('/verify-email/{id}/{hash}')->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify')->uses([\App\Auth\Http\Portal\Controllers\VerifyEmailController::class, '__invoke']);
    $router->post('/email/verification-notification')->middleware(['auth', 'throttle:6,1'])->name('verification.send')->uses([\App\Auth\Http\Portal\Controllers\EmailVerificationNotificationController::class, 'store']);

    $router->get('/confirm-password')->middleware('auth')->name('password.confirm')->uses([\App\Auth\Http\Portal\Controllers\ConfirmablePasswordController::class, 'show']);
    $router->post('/confirm-password')->middleware('auth')->name('password.confirm')->uses([\App\Auth\Http\Portal\Controllers\ConfirmablePasswordController::class, 'store']);

    $router->get('/logout')->middleware('auth')->name('logout')->uses([\App\Auth\Http\Portal\Controllers\AuthenticatedSessionController::class, 'destroy']);
});
