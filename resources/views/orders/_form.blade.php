{!! Form::hidden('entity_id',$order->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('created_at', __('Created At'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('created_at',$order->created_at ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'data-mask' => '00/00/0000', 'class'=>'form-control'.($errors->has('created_at') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-name">
            <strong>@error('created_at') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
