<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function authentificate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $errors = $this->validateFields($request, 'login');
        if ($errors) return $errors;

        $remember = $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            $this->redirectToMain($request);
        } else {
            return redirect(RouteServiceProvider::LOGIN)->withErrors([
                'login-error' => 'Oops! Smth went wrong!'
            ]);
        }

    }

    public function register(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
            'name' => ['required']
        ]);

        $errors = $this->validateFields($request, 'registration');
        if ($errors) return $errors;

        $remember = $request->input('remember', false);
        $user = User::create($credentials);

        if ($user) {
            if (Auth::login($user, $remember)) {
                $this->redirectToMain($request);
            } else {
                return redirect(RouteServiceProvider::LOGIN)->withErrors([
                    'registration-error' => 'Oops! Smth went wrong!'
                ]);
            }
        } else {
            return redirect(RouteServiceProvider::LOGIN)->withErrors([
                'registration-error' => 'Oops! Smth went wrong!'
            ]);
        }
    }

    private function validateFields($request, $mode) {
        $ruleset = UserController::generate_rules($mode);
        $redirect_path = $mode === 'login' ? 'auth.login' : 'auth.register';

        if (!sizeof($ruleset)) {
            return redirect($redirect_path)->withErrors(["$mode-error" => 'Smth unpredictable has happened!']);
        }

        $validator = Validator::make($request->all(), $ruleset);

        if ($validator->fails()) {
            return redirect($redirect_path)->withErrors($validator)->withInput();
        }

        return null;
    }

    private function redirectToMain(Request $request) {
        $request->session()->regenerate();
        return redirect()->intended('/app/main');
    }
}
