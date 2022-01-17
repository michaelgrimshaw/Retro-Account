<?php

namespace App\Auth\Http\Admin\Controllers;

use App\Auth\Http\Admin\Requests\LoginRequest;
use App\Core\Http\Admin\Controllers\AdminController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class AuthenticatedSessionController
 *
 * @package App\Auth\Http\Admin\Controllers
 */
class AuthenticatedSessionController extends AdminController
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.admin.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Auth\Http\Admin\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        auth('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
