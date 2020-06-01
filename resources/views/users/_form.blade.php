{!! Form::hidden('entity_id',$user->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('name',$user->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-name">
            <strong>@error('name') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('email', __('E-Mail Address'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::email('email',$user->email ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'email', 'class'=>'form-control'.($errors->has('email') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-email">
            <strong>@error('email') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('telephone', __('Telephone'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('telephone',$user->telephone ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'phone', 'class'=>'form-control'.($errors->has('telephone') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-telephone">
            <strong>@error('telephone') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row{{isset($hide_profile) ? ' d-none' : ''}}">
    {!! Form::label('is_admin', __('Profile'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::select('is_admin',\App\User::types(),$user->is_admin ?? 0,['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('is_admin') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback" role="alert" id="invalid-is_admin">
            <strong>@error('is_admin') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('#telephone').mask(SPMaskBehavior, spOptions);
    });
</script>
