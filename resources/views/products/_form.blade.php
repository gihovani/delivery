{!! Form::hidden('entity_id',$product->id ?? '', ['id' => 'entity_id']) !!}
<div class="row">
    <div class="col-md-7">
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
            {!! Form::label('description', __('Description'), ['class'=>'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::textarea('description',$product->description ?? '',['required' => true, 'disabled' => (isset($disabled)), 'autocomplete' => 'description', 'class'=>'form-control'.($errors->has('description') ? ' is-invalid' : '')]) !!}

                <span class="invalid-feedback" role="alert" id="invalid-description">
                <strong>@error('description') {{ $message }} @enderror</strong>
            </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('items', __('Product Items'), ['class'=>'col-form-label']) !!}
            {!! Form::select('items[]',App\Item::toOptionList(),$product->items ?? '',['multiple' => true, 'disabled' => (isset($disabled)), 'style'=> 'height:300px', 'class'=>'form-control'.($errors->has('items[]') ? ' is-invalid' : '')]) !!}

            <span class="invalid-feedback" role="alert" id="invalid-name">
                <strong>@error('items[]') {{ $message }} @enderror</strong>
            </span>
        </div>
    </div>
</div>
<?php if (isset($product)): ?>
<div class="form-group row justify-content-center">
    <div class="col-10">
        <table class="table table-bordered data-table">
            <caption>{{__('Variations')}}</caption>
            <thead>
            <tr>
                <th width="20%">{{__('Id')}}</th>
                <th width="50%">{{__('Name')}}</th>
                <th width="30%">{{__('Price')}}</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($product->category->variations as $variation): ?>
            <tr>
                <td>{!! Form::text('variation['.$variation->id.'][id]',$variation->id,['readonly' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('variation['.$variation->id.'][id]') ? ' is-invalid' : '')]) !!}</td>
                <td>{!! Form::text('variation['.$variation->id.'][name]',$variation->name,['readonly' => true, 'disabled' => (isset($disabled)), 'class'=>'form-control'.($errors->has('variation['.$variation->id.'][name]') ? ' is-invalid' : '')]) !!}</td>
                <td>{!! Form::text('variation['.$variation->id.'][price]',$product->variation[$variation->id] ?? 0,['required' => true, 'disabled' => (isset($disabled)), 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true', 'class'=>'form-control'.($errors->has('variation['.$variation->id.'][price]') ? ' is-invalid' : '')]) !!}</td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif;?>
