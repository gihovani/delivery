{!! Form::hidden('entity_id',$productItem->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('name',$productItem->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-name">
            <strong>@error('name') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('price', __('Price'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('price',$productItem->price ?? 0,['required' => true, 'disabled' => (isset($disabled)), 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'class'=>'form-control'.($errors->has('price') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-price">
            <strong>@error('price') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
