<div class="row">
    <div class="col-md-6">
        {!! Form::hidden('entity_id',$variation->id ?? '', ['id' => 'entity_id']) !!}
        <div class="form-group row">
            {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::text('name',$variation->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-name">
                    <strong>@error('name') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('description', __('Description'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::textarea('description',$variation->description ?? '',['disabled' => (isset($disabled)), 'autocomplete' => 'description', 'class'=>'form-control'.($errors->has('description') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-description">
                    <strong>@error('description') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('image', __('Image'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::file('image',['required' => !isset($variation), 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('image') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-category_id">
                    <strong>@error('image') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('items', __('Variation Items'), ['class'=>'col-form-label']) !!}
            {!! Form::select('items[]',App\Item::toOptionList(),$variation->items ?? '',['multiple' => true, 'disabled' => (isset($disabled)), 'style'=> 'height:315px', 'class'=>'form-control'.($errors->has('items') ? ' is-invalid' : '')]) !!}

            <span class="invalid-feedback" role="alert" id="invalid-name">
                <strong>@error('items') {{ $message }} @enderror</strong>
            </span>
        </div>
    </div>
</div>
