@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="text-center">
            @auth()
                Olá {{auth()->user()->name}}.
            @else
                {{ env('APP_NAME') }}
            @endauth
        </h1>
    </div>
@endsection
