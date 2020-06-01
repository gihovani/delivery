@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('product_items.index')}}">{{ __('Product Items') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Show Data')}}</li>
    </ol>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Show Data') }}</div>

                <div class="card-body">
                    @include('product_items._form', ['disabled' => true])

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a class="btn btn-info" href="{{ route('product_items.index') }}">
                                {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
