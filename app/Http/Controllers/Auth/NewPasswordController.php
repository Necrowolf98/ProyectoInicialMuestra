<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\NewPasswordResetRequest;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return Inertia::render('auth/reset-password', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );


        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida.!');
        }

        throw ValidationException::withMessages([
            'email' => [(trans($status) == 'This password reset token is invalid.') 
            ? 'Su token de restablecimiento de contraseña no es válido. Por favor generar otro enlace.' 
            : 'No podemos encontrar un usuario con esa dirección de correo electrónico, debido a que modifico en enlace. Por favor generar otro enlace.'],
        ]);
    }
}
