@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('variations.index')}}">{{ __('Variations') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Add New')}}</li>
    </ol>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add New') }}</div>

                <div class="card-body">
                    <form action="{{ route('variations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('variations._form')

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2 btn-group btn-group-justified">
                                <a class="btn btn-outline-secondary" href="{{ route('variations.index') }}">
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
