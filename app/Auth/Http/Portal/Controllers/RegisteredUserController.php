<?php

namespace App\Auth\Http\Portal\Controllers;

use App\Core\Http\Portal\Controllers\PortalController;
use App\Core\Providers\RouteServiceProvider;
use App\User\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * Class RegisteredUserController
 *
 * @package App\Auth\Http\Portal\Controllers
 */
class RegisteredUserController extends PortalController
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.portal.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));

        event(new Registered($user));

        auth('portal')->login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
