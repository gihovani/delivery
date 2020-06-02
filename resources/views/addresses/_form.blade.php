<div class="form-group row">
    {!! Form::label('zipcode', __('Zip Code'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('zipcode',$address->zipcode ?? '',['required' => true, 'autofocus' => 'true', 'disabled' => (isset($disabled)), 'autocomplete' => 'zipcode', 'data-mask' => '00000-000', 'class'=>'form-control'.($errors->has('zipcode') ? ' is-invalid' : '') ]) !!}

        @error('zipcode')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    {!! Form::label('street', __('Street'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('street',$address->street ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'street', 'class'=>'form-control'.($errors->has('street') ? ' is-invalid' : '') ]) !!}

        @error('street')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    {!! Form::label('number', __('Number'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('number',$address->number ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'number', 'class'=>'form-control'.($errors->has('number') ? ' is-invalid' : '') ]) !!}

        @error('number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    {!! Form::label('complement', __('Complement'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('complement',$address->complement ?? '',['disabled' => (isset($disabled)), 'autocomplete' => 'complement', 'class'=>'form-control'.($errors->has('complement') ? ' is-invalid' : '') ]) !!}

        @error('complement')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    {!! Form::label('neighborhood', __('Neighborhood'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('neighborhood',$address->neighborhood ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'neighborhood', 'class'=>'form-control'.($errors->has('neighborhood') ? ' is-invalid' : '') ]) !!}

        @error('neighborhood')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    {!! Form::label('city', __('City'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::text('city',$address->zipcode ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'city', 'class'=>'form-control'.($errors->has('city') ? ' is-invalid' : '') ]) !!}

        @error('city')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    {!! Form::label('state', __('State'),['class'=>'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-7">
        {!! Form::select('state',\App\Address::ufs(),$address->state ?? '',['required' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('state') ? ' is-invalid' : '') ]) !!}

        @error('state')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var $street = $('#street');
        var $neighborhood = $('#neighborhood');
        var $city = $('#city');
        var $state = $('#state');
        var $number = $('#number');
        var $complement = $('#complement');
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
        $('#zipcode').blur(function() {
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
                        alert('CEP não encontrado.');
                    }
                });
            } //end if
        });
    });
</script>
