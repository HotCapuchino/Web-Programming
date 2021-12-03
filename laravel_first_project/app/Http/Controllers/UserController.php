<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public static function generate_rules($mode) {
        if ($mode === 'login') {
            return array(
                'email' => ['required', 'email'],
                'password' => ['required']
            );
        } else if ($mode === 'registration') {
            return array(
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed'],
                'name' => ['required']
            );
        } else if ($mode === 'edit') {
            return array(
                'email' => ['required', 'email'],
                'old_password' => function($attribute, $value, $fail) {
                    $user = Auth::user();

                    $hashed_password = Hash::make($value);
                    if ($user['password'] !== $hashed_password) {
                        $fail('Old password is incorrect!');
                    }
                },
                'password' => ['required', function($attribute, $value, $fail) {
                    $user = Auth::user();

                    $hashed_password = Hash::make($value);
                    if ($user['password'] === $hashed_password) {
                        $fail('New password can\'t be the same as old one!');
                    }
                }],
                'name' => ['required']
            );
        }
        return [];
    }

    public static function render_main() {
        $user_data = [
            'name' => Auth::user()['name'],
            'email' => Auth::user()['email']
        ];

        return parent::render_page('pages.main', $user_data);
    }

    public static function edit_user(Request $request) {
        $user = Auth::user();

        $validator = Validator::make($request->all(), UserController::generate_rules('edit'));

        if ($validator->fails()) {
            redirect('pages.main')->withErrors($validator)->withInput();
        }


        // $user->save();
    }
}
