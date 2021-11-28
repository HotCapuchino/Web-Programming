<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        }
        return [];
    }
}
