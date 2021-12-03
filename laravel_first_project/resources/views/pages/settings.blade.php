@extends('layout.app_layout')

@section('title')
    Settings
@endsection

@section('app-content--inner')
    <div class="settings-container">
        <div class="header">Settings</div>
        <form method="POST" action="/app/settings/edit">
            @csrf
            <label>
                <span>Warn me about repeated bindings</span>
                <input type="checkbox"/>
            </label>
            <div class="password-settings-block">
                <div class="password-settings-block--strength">
                    <div>Passwords strength:</div>
                    <label>
                        <input type="radio" value="weak" name="password-strength"/>
                        <span>Weak</span>
                    </label>
                    <label>
                        <input type="radio" value="medium" name="password-strength"/>
                        <span>Medium</span>
                    </label>
                    <label>
                        <input type="radio" value="strong" name="password-strength"/>
                        <span>Strong</span>
                    </label>
                </div>
            </div>
            <label>
                <span>Remember Me</span>
                <input type="checkbox"/>
            </label>
            <button type="submit">Save settings</button>
        </form>
    </div>
@endsection
