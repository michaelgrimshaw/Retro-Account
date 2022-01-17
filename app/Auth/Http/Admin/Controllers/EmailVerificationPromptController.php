<?php

namespace App\Auth\Http\Admin\Controllers;

use App\Core\Http\Admin\Controllers\AdminController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class EmailVerificationPromptController
 *
 * @package App\Auth\Http\Admin\Controllers
 */
class EmailVerificationPromptController extends AdminController
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.admin.verify-email');
    }
}
