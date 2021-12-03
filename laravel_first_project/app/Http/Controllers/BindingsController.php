<?php

namespace App\Http\Controllers;

use App\Models\Binding;
use App\Models\UserSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BindingsController extends Controller
{
    public static function render_bindings() {
        $bindings = Binding::where('user_id', Auth::user()['id'])->get()->toArray();
        $settings = UserSettings::where('user_id', Auth::user()['id'])->get()->toArray()[0];

        $passwords = array_map(function($row) {
            return [
                'password_id' => $row['id'],
                'password' => $row['password']
            ];
        }, $bindings);

        if ($settings['warn_password_strength']) {
            $passwords = BindingsController::check_password_strength($passwords, $settings['password_strength']);
        }
        if ($settings['warn_repeat_password']) {
            $passwords = BindingsController::check_repeated_passwords($passwords);
        }

        $bindings = array_map(function ($pswd_obj) use ($bindings) {
            $index = -1;
            for ($i = 0; $i < sizeof($bindings); $i++) {
                if ($bindings[$i]['id'] === $pswd_obj['id']) {
                    $index = $i;
                }
            }

            $elem = null;

            if ($index > 0) {
                if (array_key_exists('weak', $pswd_obj)) {
                    $elem = array_merge($bindings[$index], ['weak' => $pswd_obj['weak']]);
                }
                if (array_key_exists('repeated', $pswd_obj)) {
                    $elem = array_merge($bindings[$index], ['repeated' => $pswd_obj['repeated']]);
                }
            }

            return $elem;
        }, $passwords);

        $bindings_data = [
            'bindings_data' => $bindings
        ];

        return parent::render_page('pages.bindings', $bindings_data);
    }

    private static function check_password_strength($bindings_passwords, $password_strength) {
        $password_bindings_validation = UserSettingsController::get_password_bindings_validation();
        return array_map(function($pswd_obj) use ($password_bindings_validation, $password_strength, $bindings_passwords) {
            $validator = Validator::make($pswd_obj['password'], $password_bindings_validation[$password_strength]);
            $weak = false;

            if ($validator->fails()) {
                $weak = true;
            }

            return array_merge($pswd_obj, ['weak' => $weak]);
        }, $bindings_passwords);
    }

    private static function check_repeated_passwords($bindings) {
        $repeated = [];

        for ($i = 0; $i < sizeof($bindings); $i++) {
            for ($j = $i + 1; $j < sizeof($bindings) - 1; $j++) {
                if ($bindings[$i]['password'] === $bindings[$j]['password']) {
                    $repeated_index = -1;

                    for ($k = 0; $k < sizeof($repeated); $k++) {
                        if ($repeated[$k]['id'] === $bindings[$i]['id']) {
                            $repeated_index = $k;
                            break;
                        }
                    }

                    if ($repeated_index >= 0) {
                        $repeated[$repeated_index] = [
                            'id' => $repeated[$repeated_index]['id'],
                            'amount' => $repeated[$repeated_index]['amount'] + 1
                        ];
                    } else {
                        $repeated[$repeated_index] = [
                            'id' => $bindings[$i]['id'],
                            'amount' => 1,
                        ];
                    }
                }
            }
        }

        for ($i = 0; $i < sizeof($bindings); $i++) {
            $repeated_index = -1;

            for ($j = 0; $j < sizeof($repeated); $j++) {
                if ($repeated[$j]['id'] === $bindings[$i]['id']) {
                    $repeated_index = $j;
                    break;
                }
            }
            $amount = 0;
            if ($repeated_index) {
                $amount = $repeated[$repeated_index]['amount'];
            }
            $bindings[$i] = array_merge($bindings[$i], ['repeated' => $amount]);
        }

        return $bindings;
    }

    public static function create_binding(Request $request) {
        $settings = UserSettings::where('user_id', Auth::user()['id'])->get()->toArray()[0];
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'password' => UserSettingsController::get_password_bindings_validation()[$settings['password_strength']],
        ]);

        if ($validator->fails()) {
            return redirect('/app/bindings')->withErrors($validator)->withInput();
        }

        $binding = Binding::create($request->toArray());
        if ($binding) {
            return redirect('/app/bindings');
        } else {
            return redirect('/app/bindings')->withErrors([
                'create-binding-error' => 'Oops! Something went wrong while creating binding!'
            ]);
        }

        return redirect('/app/bindings');
    }

    public static function edit_binding(Request $request, $id) {
        var_dump($id);
    }

    public static function remove_binding(Request $request, $id) {
        var_dump($id);
    }
}
