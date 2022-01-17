<?php

namespace App\Auth\Http\Portal\Controllers;

use App\Core\Http\Portal\Controllers\PortalController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class EmailVerificationNotificationController
 *
 * @package App\Auth\Http\Portal\Controllers
 */
class EmailVerificationNotificationController extends PortalController
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
            return redirect()->route('portal.account.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
