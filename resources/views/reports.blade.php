@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('Reports')}}</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        </div>
                    @endif
                    <form class="row" action="{{route('reports.orders')}}" method="POST">
                        @csrf
                        {!! Form::label('start', __('Orders'), ['class' => 'col-md-2 col-form-label']) !!}
                        <div class="col-md-4">
                            {!! Form::text('start', date('d/m/Y'), ['required' => true, 'data-mask' => '00/00/0000', 'class'=>'form-control'.($errors->has('start') ? ' is-invalid' : '')]) !!}
                            <span class="invalid-feedback invalid-start" role="alert">
                                <strong>@error('start') {{ $message }} @enderror</strong>
                            </span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::text('end', date('d/m/Y'), ['required' => true, 'data-mask' => '00/00/0000', 'class'=>'form-control'.($errors->has('end') ? ' is-invalid' : '')]) !!}
                            <span class="invalid-feedback invalid-end" role="alert">
                                <strong>@error('end') {{ $message }} @enderror</strong>
                            </span>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary  btn-block">OK</button>
                        </div>
                    </form>
                    <form class="row mt-4" action="{{route('reports.transactions')}}" method="POST">
                        @csrf
                        {!! Form::label('date', __('Transactions'), ['class' => 'col-md-2 col-form-label']) !!}
                        <div class="col-md-8">
                            {!! Form::text('date', date('d/m/Y'), ['required' => true, 'data-mask' => '00/00/0000', 'class'=>'form-control'.($errors->has('date') ? ' is-invalid' : '')]) !!}
                            <span class="invalid-feedback invalid-date" role="alert">
                                <strong>@error('date') {{ $message }} @enderror</strong>
                            </span>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary btn-block">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
