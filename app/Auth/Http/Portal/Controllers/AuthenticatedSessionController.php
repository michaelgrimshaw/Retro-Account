<?php

namespace App\Auth\Http\Portal\Controllers;

use App\Auth\Http\Portal\Requests\LoginRequest;
use App\Core\Http\Portal\Controllers\PortalController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class AuthenticatedSessionController
 *
 * @package App\Auth\Http\Portal\Controllers
 */
class AuthenticatedSessionController extends PortalController
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.portal.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Auth\Http\Portal\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('portal.account.index');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        auth('portal')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
