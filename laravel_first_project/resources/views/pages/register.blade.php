@extends('layout.auth_layout')

@section('title')
    Registration
@endsection

@section('content-auth--inner')
<div>
    <h1>Sign Up</h1>
    <form method="POST" action="/auth/register">
        @csrf
        <label>
            <div>Name</div>
            @error('name')
                <div>{{$message}}</div>
            @enderror
            <input type="text" required placeholder="name" name="name" value="{{old('name')}}">
        </label>
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
        <label>
            <div>Password confirmation</div>
            @error('password_confirmation')
                <div>{{$message}}</div>
            @enderror
            <input type="password" required placeholder="confirm password" name="password_confirmation">
        </label>
        <button type="submit">Sign up</button>
    </form>
    @error('registration-error')
        <div>{{$message}}</div>
    @enderror
</div>
@endsection
