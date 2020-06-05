<div class="form-group row">
    {!! Form::label('zipcode', __('Zip Code'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('zipcode',$address->zipcode ?? '',['required' => true, 'autofocus' => 'true', 'disabled' => (isset($disabled)), 'autocomplete' => 'zipcode', 'data-mask' => '00000-000', 'class'=>'form-control input-zipcode'.($errors->has('zipcode') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-zipcode" role="alert">
            <strong>@error('zipcode') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('street', __('Street'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('street',$address->street ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'street', 'class'=>'form-control input-street'.($errors->has('street') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-street" role="alert">
            <strong>@error('street') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('number', __('Number'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('number',$address->number ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'number', 'class'=>'form-control input-number'.($errors->has('number') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-number" role="alert">
            <strong>@error('number') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('complement', __('Complement'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('complement',$address->complement ?? '',['disabled' => (isset($disabled)), 'autocomplete' => 'complement', 'class'=>'form-control input-complement'.($errors->has('complement') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-complement" role="alert">
            <strong>@error('complement') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('neighborhood', __('Neighborhood'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('neighborhood',$address->neighborhood ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'neighborhood input-neighborhood', 'class'=>'form-control'.($errors->has('neighborhood') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-neighborhood" role="alert">
            <strong>@error('neighborhood') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('city', __('City'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('city',$address->zipcode ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'city', 'class'=>'form-control input-city'.($errors->has('city') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-city" role="alert">
            <strong>@error('city') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('state', __('State'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::select('state',\App\Address::ufs(),$address->state ?? '',['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control input-state'.($errors->has('state') ? ' is-invalid' : '') ]) !!}

        <span class="invalid-feedback invalid-state" role="alert">
            <strong>@error('state') {{ $message }} @enderror</strong>
        </span>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var $street = $('.input-street');
        var $neighborhood = $('.input-neighborhood');
        var $city = $('.input-city');
        var $state = $('.input-state');
        var $number = $('.input-number');
        var $complement = $('.input-complement');
        var oldCep = '';

        function clearFields() {
            $street.val('');
            $neighborhood.val('');
            $city.val('');
            $state.val('');
            $number.val('');
            $complement.val('');
        }
        function readOnlyFields(property) {
            $street.prop('readonly', property);
            $neighborhood.prop('readonly', property);
            $city.prop('readonly', property);
            $state.prop('readonly', property);
            $number.prop('readonly', property);
            $complement.prop('readonly', property);
        }

        //Quando o campo cep perde o foco.
        $('.input-zipcode').blur(function() {
            //Nova variável 'cep' somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');
            if (cep === oldCep) {
                return '';
            }

            oldCep = cep;
            //Verifica se campo cep possui valor informado.
            if (cep.length !== 8) {
                clearFields();
                alert('Formato de CEP inválido.');
            }

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                readOnlyFields(true);
                //Consulta o webservice viacep.com.br/
                $.getJSON('https://viacep.com.br/ws/'+ cep +'/json/?callback=?', function(dados) {
                    readOnlyFields(false);
                    if (!('erro' in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $street.val(dados.logradouro);
                        $neighborhood.val(dados.bairro);
                        $city.val(dados.localidade);
                        $state.val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        clearFields();
                        myAlert('CEP não encontrado.');
                    }
                });
            } //end if
        });
    });
</script>
