@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('variations.index')}}">{{ __('Variations') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Edit Data')}}</li>
    </ol>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Data') }}</div>

                <div class="card-body">
                    <form action="{{ route('variations.update', $variation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('variations._form')

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-info" href="{{ route('variations.index') }}">
                                    {{ __('Back') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
