<?php

namespace App\Auth\Http\Admin\Controllers;

use App\Core\Http\Admin\Controllers\AdminController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class EmailVerificationNotificationController
 *
 * @package App\Auth\Http\Admin\Controllers
 */
class EmailVerificationNotificationController extends AdminController
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
