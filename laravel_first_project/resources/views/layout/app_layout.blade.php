@extends('index')

@section('content-app')
    <div class="app-layout-container">
        @include('components.navbar')
        @yield('app-content--inner')
    </div>
@endsection
