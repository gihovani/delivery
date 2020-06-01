{!! Form::hidden('entity_id',$variation->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('category_id', __('Category'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::select('category_id',\App\Category::toOptionList(),$variation->category_id ?? 0,['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('category_id') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-category_id">
            <strong>@error('category_id') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('name',$variation->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-name">
            <strong>@error('name') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
