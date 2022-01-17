<?php

namespace App\Auth\Http\Admin\Controllers;

use App\AdminUser\Models\AdminUser;
use App\Core\Http\Admin\Controllers\AdminController;
use App\Core\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

/**
 * Class RegisteredUserController
 *
 * @package App\Auth\Http\Admin\Controllers
 */
class RegisteredUserController extends AdminController
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.admin.register');
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

        $user = AdminUser::create($request->only(['name', 'email', 'password']));

        event(new Registered($user));

        auth('admin')->login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
