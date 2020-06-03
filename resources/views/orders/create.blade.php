@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('orders.index')}}">{{ __('Orders') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Add New')}}</li>
    </ol>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-3">
                    @foreach($products as $product)
                        <div class="col mb-2">
                            <div class="card product-card">
                                <img src="{{$product->image_url}}" class="card-img-top" alt="{{$product->name}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->name}}</h5>
                                    <p class="card-text">{{$product->description}}</p>
                                </div>
                                <div class="card-footer">
                                    @for ($i=0;$i<$product->pieces;$i++)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="variation_{{$product->id}}_{{$i}}">{{__('Variation')}}{{$i+1}}</label>
                                            </div>
                                            {!! Form::select('quantity',$product->getVariationToOptionList(),'',['required' => true, 'id' => 'variation_'.$product->id.'_'.$i, 'class' => 'custom-select']) !!}
                                        </div>
                                    @endfor
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"
                                                   for="quantity_{{$product->id}}">{{$product->price_formated}}</label>
                                        </div>
                                        {!! Form::number('quantity',1,['required' => true, 'id' => 'quantity_'.$product->id, 'class' => 'form-control']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button">{{__('Add')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3">
                <h2>Cart Items</h2>
            </div>
        </div>
    </div>
    <script>
        var products = @json($products);
        var categories = @json($categories);
    </script>
@endsection
