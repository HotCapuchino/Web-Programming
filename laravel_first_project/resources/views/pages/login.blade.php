@extends('layout.auth_layout')

@section('title')
    Login
@endsection

@section('content-auth--inner')
<div>
    <h1>Log In</h1>
    <form method="POST" action="/auth/login">
        @csrf
        <label>
            <div>Email</div>
            @error('email')
                <div>{{$message}}</div>
            @enderror
            <input type="email" required placeholder="email" name="email" value="{{old('email')}}">
        </label>
        <label>
            <div>Password</div>
            @error('password')
                <div>{{$message}}</div>
            @enderror
            <input type="password" required placeholder="password" name="password">
        </label>
        <button>Sign in</button>
    </form>
    @error('login-error')
        <div>{{$message}}</div>
    @enderror
</div>
@endsection
