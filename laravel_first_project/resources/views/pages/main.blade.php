@extends('layout.app_layout')

@section('title')
    Main
@endsection

@section('app-content--inner')
    <div class="main-container">
        <section class="welcome-app"></section>
        <section class="user-info">
            <div class="user-info-user-credentials">
                <form action="/app/main/edit" method="POST">
                    @csrf
                    <label>
                        <div>Name: {{$name}}</div>
                        <button>Change</button>
                        <input type="text" name="name" value="{{$name}}">
                    </label>
                    <label>
                        <div>Email: {{$email}}</div>
                        <button>Change</button>
                        <input type="text" name="email" value="{{$email}}">
                    </label>
                    <button>Change password</button>
                    <label>
                        <div>Old password</div>
                        <input type="password" name="old_password">
                    </label>
                    <label>
                        <div>New password</div>
                        <input type="password" name="password">
                    </label>
                </form>
            </div>
        </section>
    </div>
@endsection
