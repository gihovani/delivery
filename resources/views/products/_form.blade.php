{!! Form::hidden('entity_id',$product->id ?? '', ['id' => 'entity_id']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('category_id', __('Category'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::select('category_id',\App\Category::toOptionList(),$product->category_id ?? 0,['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('category_id') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-category_id">
                    <strong>@error('category_id') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::text('name',$product->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-name">
                    <strong>@error('name') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('price', __('Price'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::text('price',$product->price ?? '',['required' => true, 'disabled' => (isset($disabled)), 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'class'=>'form-control'.($errors->has('price') ? ' is-invalid' : '')]) !!}
                <span class="invalid-feedback" role="alert" id="invalid-price">
                    <strong>@error('price') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('pieces', __('Pieces'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::number('pieces',$product->pieces ?? 1,['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('pieces') ? ' is-invalid' : '')]) !!}
                <span class="invalid-feedback" role="alert" id="invalid-pieces">
                    <strong>@error('pieces') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('description', __('Description'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::textarea('description',$product->description ?? '',['disabled' => (isset($disabled)), 'autocomplete' => 'description', 'class'=>'form-control'.($errors->has('description') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-description">
                    <strong>@error('description') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('image', __('Image'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::file('image',['required' => !isset($product), 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('image') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-category_id">
                    <strong>@error('image') {{ $message }} @enderror</strong>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('variations', __('Variations'), ['class'=>'col-form-label']) !!}
            {!! Form::select('variations[]',App\Variation::toOptionList(),$product->variations ?? '',['multiple' => true, 'disabled' => (isset($disabled)), 'style'=> 'height:475px', 'class'=>'form-control'.($errors->has('variations') ? ' is-invalid' : '')]) !!}

            <span class="invalid-feedback" role="alert" id="invalid-name">
                <strong>@error('variations') {{ $message }} @enderror</strong>
            </span>
        </div>
    </div>
</div>
