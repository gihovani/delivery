@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.show') }}">
                        @csrf

                        @include('users._form', ['hide_profile' => true])

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 btn-group btn-group-justified">
                                <a class="btn btn-outline-secondary" href="{{ route('home') }}">
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
