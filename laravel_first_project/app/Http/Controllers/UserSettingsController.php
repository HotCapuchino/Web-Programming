<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Rules\ConsistNumbers;
use App\Rules\MixedCase;
use App\Rules\SpecialCharacters;

class UserSettingsController extends Controller
{
    public static function render_settings() {
        $settings = UserSettings::where('user_id', Auth::user()['id'])->get()->toArray();
        $remember = boolval(Auth::user()['remember_token']);
        $settings_data = [
            'settings_data' => array_merge($settings, ['remember' => $remember])
        ];

        parent::render_page('pages.settings', $settings_data);
    }

    public static function init_settings($user_id) {
        $default_settings = null;

        try {
            $default_settings = UserSettings::create(array_merge(
                UserSettings::$init_settings,
                ['user_id' => $user_id]
            ));
        } catch (Exception $e) {
            return false;
        }

        return !$default_settings ? false : true;
    }

    public static function edit_user_settings(Request $request) {
        $user = Auth::user();
        $user->setRememberToken(Str::random(60));
        // $user->save();

        UserSettings::where('user_id', $user['id'])->update($request);
    }

    public static function get_password_bindings_validation() {
        return [
            'weak' => ['min:4', 'required', new ConsistNumbers],
            'medium' => ['min:8', 'required', new ConsistNumbers, new MixedCase],
            'strong' => ['min:16', 'required', new ConsistNumbers, new MixedCase, new SpecialCharacters],
        ];
    }
}
