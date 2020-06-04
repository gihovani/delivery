@extends('layouts.app')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{route('orders.index')}}">{{ __('Orders') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Add New')}}</li>
    </ol>
@endsection
@section('content')
    <div class="container cart-page">
        <div class="row">
            <div class="col-md-9">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{__('Categories')}}</span>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" checked value=""> {{__('All')}}
                        </label>
                        @foreach($categories as $category)
                            <label class="btn btn-secondary active">
                                <input type="radio" name="options"
                                       value="category-{{$category->id}}"> {{$category->name}}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-3">
                    @foreach($products as $product)
                        <div class="col mb-2 category-{{$product->category_id}}">
                            <form class="card product-form">
                                {!! Form::hidden('id', $product->id) !!}
                                {!! Form::hidden('name', $product->name) !!}
                                {!! Form::hidden('price', $product->price) !!}
                                {!! Form::hidden('image_url', $product->image_url) !!}
                                <img src="{{$product->image_url}}" class="card-img-top" alt="{{$product->name}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->name}}</h5>
                                    <p class="card-text">{{$product->description}}</p>
                                </div>
                                <div class="card-footer">
                                    @for ($i=0;$i<$product->pieces;$i++)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text"
                                                       for="variation_{{$product->id}}_{{$i}}">{{__('Variation')}}{{$i+1}}</label>
                                            </div>
                                            {!! Form::select('variation[]',$product->getVariationToOptionList(),'',['required' => true, 'id' => 'variation_'.$product->id.'_'.$i, 'class' => 'variation-select custom-select']) !!}
                                        </div>
                                    @endfor
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"
                                                   for="quantity_{{$product->id}}">{{$product->price_formated}}</label>
                                        </div>
                                        {!! Form::number('quantity',1,['required' => true, 'id' => 'quantity_'.$product->id, 'class' => 'form-control']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-add-to-cart"
                                                    type="submit">{{__('Add To Cart')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3">
                <h2>{{__('Shopping Cart')}}</h2>
                <div id="cart-items"></div>
                <div id="cart-actions">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__('SubTotal')}}</span>
                        </div>
                        <input name="subtotal" readonly id="total-items" class="form-control"/>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__('Discount')}}</span>
                        </div>
                        <input name="discount" id="discount" class="form-control" data-mask="#.##0,00" data-mask-reverse="true" />
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-apply-discount"
                                    type="button">{{__('Apply')}}</button>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__('Total')}}</span>
                        </div>
                        <input name="total" readonly id="total" class="form-control"/>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__('Method')}}</span>
                        </div>
                        {!! Form::select('payment_method', \App\Order::getPaymentMethodToOptionList(), '', ['required' => true, 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var variations = @json($variations);
            var CartItem = function () {
                var args = arguments[0];
                if (!args.hasOwnProperty('id') &&
                    !args.hasOwnProperty('name') &&
                    !args.hasOwnProperty('price') &&
                    !args.hasOwnProperty('quantity')) {
                    this.valid = false;
                    return;
                }
                this.id = parseInt(args.id);
                this.name = args.name;
                this.price = parseFloat(args.price);
                this.quantity = parseInt(args.quantity);
                this.image_url = args.hasOwnProperty('image_url') ? args.image_url : '';
                this.description = args.hasOwnProperty('description') ? args.description : '';
                this.observation = args.hasOwnProperty('observation') ? args.observation : '';
                this.valid = true;
            };
            var cart = function () {
                var items = [];
                var discount = 0;
                var subTotal = 0;
                var total = 0;
                var _formatCurrency = function (value) {
                    value = parseFloat(value).toFixed(2)
                    return $('<input>').val(value)
                        .mask('#.##0,00', {reverse: true})
                        .val();
                };

                var _hasItems = function () {
                    return (items.length > 0);
                };

                var _totalItems = function () {
                    subTotal = 0.0;
                    for (var i in items) {
                        var item = items[i];
                        subTotal += (item.price * item.quantity);
                    }
                    if (subTotal < discount) {
                        discount = 0;
                    }

                    total = subTotal - discount;
                };

                var _htmlItems = function () {
                    var html = '';
                    if (!_hasItems()) {
                        return '<div class="alert alert-danger" role="alert">{{__('cart empty')}}</div>';
                    }
                    for (var i in items) {
                        var item = items[i];
                        html += '<a name="cart-item' + item.id + '"></a>' +
                            '<div class="card mb-3">\n' +
                            '  <div class="row no-gutters position-relative">\n' +
                            '    <div class="col-md-4">\n' +
                            '      <img src="' + item.image_url + '" class="card-img" alt="' + item.name + '">\n' +
                            '    </div>\n' +
                            '    <div class="col-md-8">\n' +
                            '      <div class="card-body">\n' +
                            '        <h5 class="card-title">' + item.name + '</h5>\n' +
                            '        <p class="card-text">' + item.quantity + 'x' + _formatCurrency(item.price) + '</p>\n' +
                            '        <p class="card-text"><small class="text-muted">' + item.description + '</small></p>\n' +
                            '        <p class="card-text"><small class="text-muted">' + item.observation + '</small></p>\n' +
                            '      </div>\n' +
                            '    </div>\n' +
                            '  </div>\n' +
                            '    <button class="btn btn-outline-danger btn-remove-cart" data-id="' + i + '"><i class="far fa-trash-alt"></i></button>\n' +
                            '</div>';

                    }
                    return html;
                };
                var _toHtml = function () {
                    _totalItems();
                    $('#cart-actions').toggleClass('d-none', !_hasItems());
                    $('#total-items').val(_formatCurrency(subTotal));
                    $('#discount').val(_formatCurrency(discount));
                    $('#total').val(_formatCurrency(total));
                    $('#cart-items').html(_htmlItems());
                };
                _toHtml();
                return {
                    add: function (item) {
                        var cartItem = new CartItem(item);
                        if (!cartItem.valid) {
                            myAlert('{{__("Couldn't add item")}}');
                            return '';
                        }
                        items.push(cartItem);
                        myAlert(cartItem.name + ' {{__('has been added to the cart.')}}');
                        this.toHtml();
                        setTimeout(function () {
                            location.hash = "#cart-item" + cartItem.id;
                        }, 50);
                    },
                    remove: function (position) {
                        var item = items.splice(position, 1);
                        if (item.length < 1) {
                            myAlert('{{__('The item could not be removed from the cart.')}}');
                            return;
                        }
                        myAlert(item[0].name + ' {{__('has been removed from the cart.')}}');
                        this.toHtml();
                    },
                    setDiscount: function(value) {
                        var tmpDiscount = (parseFloat(value)/100).toFixed(2)
                        if (tmpDiscount > subTotal) {
                            myAlert('{{__('The discount could not be applied.')}}')
                            this.toHtml();
                            return '';
                        }
                        discount = tmpDiscount;
                        this.toHtml();
                    },
                    toHtml: _toHtml
                }
            }();

            $('input[name=options]').on('change', function () {
                @foreach($categories as $category)
                $('.category-{{$category->id}}').addClass('d-none');
                @endforeach
                if (!this.value) {
                    $('.d-none').removeClass('d-none');
                } else {
                    $('.' + this.value).removeClass('d-none');
                }
            });
            var getVariation = function (variationId) {
                variationId = parseInt(variationId);
                for (var key in variations) {
                    var variation = variations[key];
                    if (variation.id === variationId) {
                        return variation;
                    }
                }
                return null;
            };
            $('body').on('submit', '.product-form', function (e) {
                e.preventDefault();
                var formValues = $(this).serializeArray();
                var description = [];
                var item = {};
                for (var key in formValues) {
                    if (formValues[key].name === 'variation[]') {
                        var variation = getVariation(formValues[key].value);
                        if (variation) {
                            description.push(variation.name);
                        }
                    } else {
                        item[formValues[key].name] = formValues[key].value;
                    }
                }
                item['description'] = description.join(', ');
                cart.add(item)
            }).on('click', '.btn-remove-cart', function (e) {
                e.preventDefault();
                var position = $(this).data('id');
                cart.remove(position);
            }).on('click', '.btn-apply-discount', function (e) {
                e.preventDefault();
                cart.setDiscount($('#discount').cleanVal());
            });

        });
    </script>
@endsection
