@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                @include('users._form')
                                <div class="form-group row">
                                    {!! Form::label('password', __('Password'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                    <div class="col-md-7">
                                        {!! Form::password('password',['required' => true, 'autocomplete' => 'new-password', 'class'=>'form-control'.($errors->has('password') ? ' is-invalid' : '') ]) !!}

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('password_confirmation', __('Confirm Password'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
                                    <div class="col-md-7">
                                        {!! Form::password('password_confirmation',['autocomplete' => 'new-password', 'class'=>'form-control']) !!}

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('addresses._form')
                            </div>
                        </div>




                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2 btn-group btn-group-justified">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
