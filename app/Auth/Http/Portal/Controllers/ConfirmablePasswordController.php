<?php

namespace App\Auth\Http\Portal\Controllers;

use App\Core\Http\Portal\Controllers\PortalController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class ConfirmablePasswordController
 *
 * @package App\Auth\Http\Portal\Controllers
 */
class ConfirmablePasswordController extends PortalController
{
    /**
     * Show the confirm password view.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.portal.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if (! auth('portal')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->route('portal.account.index');
    }
}
