
{!! Form::hidden('entity_id',$user->id ?? '', ['id' => 'entity_id']) !!}
<div class="form-group row">
    {!! Form::label('name', __('Name'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('name',$user->name ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'name', 'autofocus' => 'true', 'class'=>'form-control input-name'.($errors->has('name') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-name" role="alert">
            <strong>@error('name') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('email', __('E-Mail Address'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::email('email',$user->email ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'email', 'class'=>'form-control input-email'.($errors->has('email') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-email" role="alert">
            <strong>@error('email') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('telephone', __('Telephone'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('telephone',$user->telephone ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'phone', 'class'=>'form-control input-telephone'.($errors->has('telephone') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-telephone" role="alert">
            <strong>@error('telephone') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row{{isset($hide_profile) ? ' d-none' : ''}}">
    {!! Form::label('roles', __('Profile'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::select('roles[]',\App\User::rolesToOptionList(), isset($user->roles) ? explode(',', $user->roles) : '',['required' => !isset($hide_profile), 'multiple' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control input-roles'.($errors->has('roles') ? ' is-invalid' : '')]) !!}

        <span class="invalid-feedback invalid-roles" role="alert">
            <strong>@error('roles') {{ $message }} @enderror</strong>
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
        $('.input-telephone').mask(SPMaskBehavior, spOptions);
    });
</script>
