{!! Form::hidden('entity_id',$config->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('store', __('Store'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('store',$config->store ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'store', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('store') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-store" role="alert">
            <strong>@error('store') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('telephone', __('Telephone'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('telephone',$config->telephone ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'phone', 'class'=>'form-control input-telephone'.($errors->has('telephone') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-telephone" role="alert">
            <strong>@error('telephone') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('waiting_time', __('Waiting Time'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::number('waiting_time',$config->waiting_time ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'waiting_time', 'class'=>'form-control'.($errors->has('waiting_time') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-waiting_time" role="alert">
            <strong>@error('waiting_time') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-8 offset-md-4">
        <div class="custom-control custom-checkbox">
            {!! Form::checkbox('is_open',1, $config->is_open ?? '',['disabled' => (isset($disabled)), 'class'=>'custom-control-input'.($errors->has('is_open') ? ' is-invalid' : ''), 'id' => 'is-open']) !!}
            {!! Form::label('is-open', __('Is Open'), ['class' => 'custom-control-label']) !!}
        </div>
        <span class="invalid-feedback invalid-is_open" role="alert">
            <strong>@error('is_open') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('latitude', __('Latitude'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('latitude',$config->latitude ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'latitude', 'class'=>'form-control'.($errors->has('latitude') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-latitude" role="alert">
            <strong>@error('latitude') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('longitude', __('Longitude'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('longitude',$config->longitude ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'longitude', 'class'=>'form-control'.($errors->has('longitude') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-longitude" role="alert">
            <strong>@error('longitude') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>

<div class="form-group row">
    {!! Form::label('free_distance', __('Free Distance'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::number('free_distance',$config->free_distance ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'free_distance', 'class'=>'form-control'.($errors->has('free_distance') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-free_distance" role="alert">
            <strong>@error('free_distance') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('shipping_tax', __('Shipping Tax'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('shipping_tax',$config->shipping_tax ?? '',['required' => true, 'disabled' => (isset($disabled)), 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'autocomplete' => 'shipping_tax', 'class'=>'form-control'.($errors->has('shipping_tax') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-shipping_tax" role="alert">
            <strong>@error('shipping_tax') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>

<div class="form-group row">
    {!! Form::label('zipcode', __('Zip Code'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('zipcode',$config->zipcode ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'zipcode', 'data-mask' => '00000-000', 'class'=>'form-control input-zipcode'.($errors->has('zipcode') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-zipcode" role="alert">
            <strong>@error('zipcode') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>

<div class="form-group row">
    {!! Form::label('address', __('Address'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::textarea('address',$config->address ?? '',['disabled' => (isset($disabled)), 'autocomplete' => 'address', 'class'=>'form-control'.($errors->has('address') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-address" role="alert">
            <strong>@error('address') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('google_api_key', __('Google Api Key'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::text('google_api_key',$config->google_api_key ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'google_api_key', 'class'=>'form-control'.($errors->has('google_api_key') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-google_api_key" role="alert">
            <strong>@error('google_api_key') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('google_maps', __('Google Maps'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::url('google_maps',$config->google_maps ?? '',['disabled' => (isset($disabled)), 'autocomplete' => 'google_maps', 'class'=>'form-control'.($errors->has('google_maps') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-google_maps" role="alert">
            <strong>@error('google_maps') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('image', __('Image'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-8">
        {!! Form::file('image',['required' => !isset($config), 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('image') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-category_id" role="alert">
            <strong>@error('image') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
