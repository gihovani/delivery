@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('users.show', $address->user)}}">{{ $address->user->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{route('addresses.index', $address->user)}}">{{__('Addresses')}}</a></li>
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
                    @include('addresses._form', ['disabled' => true])

                    <div class="form-group row">
                        {!! Form::label('distance', __('Distance'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-8">
                            {!! Form::text('distance',$address->distance ?? '',['disabled' => true, 'class'=>'form-control']) !!}
                            <small class="form-text text-muted">Distância em metros.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('duration', __('Duration'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-8">
                            {!! Form::text('duration',((isset($address->duration) && !empty($address->duration)) ? App\Address::formatMoney($address->duration/100, '') : ''), ['disabled' => true, 'class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4 btn-group btn-group-justified">
                            <a class="btn btn-outline-secondary" href="{{ route('addresses.index', $address->user) }}">
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
