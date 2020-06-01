{!! Form::hidden('entity_id',$category->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('name',$category->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-name">
            <strong>@error('name') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
