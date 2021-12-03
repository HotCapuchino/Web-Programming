@extends('layout.app_layout')

@section('title')
    Bindings
@endsection

@section('app-content--inner')
    <div class="bindings-container">
        <section class="bindings-list">
           @foreach ($bindings_data as $binding)
                <div>Binding: {{$binding['name']}}</div>
                <div></div>
           @endforeach
        </section>
        <section class="bindings-creation">
            <form method="POST" action="/app/bindings/create">
                @csrf
                <label>
                    <div>Binding name:</div>
                    @error('name')
                        <div>{{$message}}</div>
                    @enderror
                    <input type="text" name="name" value="{{old('name')}}">
                </label>
                <label>
                    <div>Binding password:</div>
                    @error('password')
                        <div>{{$message}}</div>
                    @enderror
                    <input type="password" name="password" >
                </label>
                <button type="submit">Create</button>
            </form>
            @error('create-binding-error')
                <div>{{$message}}</div>
            @enderror
        </section>
    </div>
@endsection
