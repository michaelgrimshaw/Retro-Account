<?php

namespace App\Auth\Http\Portal\Controllers;

use App\Core\Http\Portal\Controllers\PortalController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class EmailVerificationPromptController
 *
 * @package App\Auth\Http\Portal\Controllers
 */
class EmailVerificationPromptController extends PortalController
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
                    : view('auth.portal.verify-email');
    }
}
