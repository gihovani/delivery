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
        @if($errors->any())
            <div class="alert alert-danger">
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            </div>
        @endif
        <div class="row">
            <div class="col-md-9">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        {!! Form::label('category-all', __('Categories'), ['class' => 'input-group-text', 'style'=> 'width: 100px']) !!}
                    </div>
                    <div class="btn-group btn-group-toggle category-filters" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="category-all" checked value=""> {{__('All')}}
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
                        <div class="col mb-2 product-card category-{{$product->category_id}}">
                            <form class="card add-to-cart">
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
                                                {!! Form::label('variation_'.$product->id, __('Variation').' '.($i+1), ['class' => 'input-group-text']) !!}
                                            </div>
                                            {!! Form::select('variation[]',$product->getVariationToOptionList(),'',['required' => true, 'id' => 'variation_'.$product->id.'_'.$i, 'class' => 'variation-select custom-select']) !!}
                                        </div>
                                    @endfor
                                    {!! Form::textarea('observation','',['placeholder' => __('Observation'), 'class' => 'form-control', 'rows' => 2]) !!}
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            {!! Form::label('quantity_'.$product->id, $product->price_formated, ['class' => 'input-group-text']) !!}
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
            <form class="col-md-3" action="{{ route('orders.store') }}" method="POST">
                @csrf
                <h2>{{__('Shopping Cart')}}</h2>
                <div id="cart-items"></div>
                <div id="cart-actions">
                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            {!! Form::label('customer-autocomplete', __('Telephone'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::hidden('customer_id', '', ['id' => 'customer-id']) !!}
                        {!! Form::text('customer-autocomplete', '', ['required' => true, 'class' => 'form-control input-telephone', 'id' => 'customer-autocomplete']) !!}
                    </div>

                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('customer-name', __('Customer'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('customer_name', '', ['readonly' => true, 'class' => 'form-control', 'id' => 'customer-name']) !!}
                    </div>

                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('customer-address', __('Address'), ['class' => 'input-group-text', 'id' => 'label-customer-address']) !!}
                        </div>
                        {!! Form::select('address_id', [], '', ['required' => true, 'class' => 'form-control', 'id' => 'customer-address']) !!}
                    </div>

                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('deliveryman-id', __('Deliveryman'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::select('deliveryman_id', \App\User::getDeliveryman(), '', ['required' => true, 'class' => 'form-control', 'id' => 'deliveryman-id']) !!}
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            {!! Form::label('subtotal', __('SubTotal'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('subtotal', '', ['readonly' => true, 'class' => 'form-control', 'id' => 'subtotal']) !!}
                    </div>
                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            {!! Form::label('discount', __('Discount'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('discount', '', ['required' => true, 'class' => 'form-control', 'id' => 'discount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
                    </div>
                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('shipping-amount', __('Shipping Amount'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('shipping_amount', '', ['required' => true, 'class' => 'form-control', 'id' => 'shipping-amount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            {!! Form::label('total', __('Total'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('total', '', ['readonly' => true, 'class' => 'form-control', 'id' => 'total']) !!}
                    </div>
                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('payment-method', __('Payment Method'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::select('payment_method', \App\Order::getPaymentMethodToOptionList(), '', ['required' => true, 'class' => 'form-control', 'id'=> 'payment-method']) !!}
                    </div>

                    <div class="input-group has-payment-in-cash d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('cash-amount', __('Cash Amount'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('cash_amount', '', ['required' => true, 'class' => 'form-control', 'id' => 'cash-amount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
                    </div>
                    <div class="input-group has-payment-in-cash d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('back-change', __('Back Change'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('back_change', '', ['readonly' => true, 'class' => 'form-control', 'id' => 'back-change']) !!}
                    </div>
                    <button disabled type="submit" id="save-order"
                            class="btn btn-success btn-block">{{ __('Save Order') }}</button>
                </div>
            </form>
        </div>
    </div>

    @include('orders.modals.user-modal', ['modal-id' => 'customer-modal'])
    @include('orders.modals.address-modal', ['modal-id' => 'address-modal'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var variations = @json($variations);
            var $customerModal = $('#customer-modal');
            var $addressModal = $('#address-modal');
            var $customerAutoComplete = $('#customer-autocomplete');
            var methodInCash = '{{\App\Order::METHOD_IN_CASH}}';
            var defaultAction = '{{route('users.store')}}';

            var showModalErrors = function (responseError) {
                var errors = JSON.parse(responseError.responseText);
                if (!errors || !errors.hasOwnProperty('errors')) {
                    return '';
                }
                for (var error in errors.errors) {
                    $('.input-' + error).addClass('is-invalid');
                    $('.invalid-' + error).find('strong')
                        .html(errors.errors[error]);
                }
            };

            var showModal = function ($modal, title) {
                $('.is-invalid')
                    .removeClass('is-invalid');
                $('.invalid-feedback')
                    .find('strong')
                    .html('');
                $modal
                    .find('.modal-title')
                    .html(title);
                $modal.modal('show');
            };

            var formFieldsToObject = function ($form) {
                if (!$form.is('form')) {
                    return {};
                }
                var item = {};
                var formValues = $form.serializeArray();
                for (var key in formValues) {
                    var name = formValues[key].name;
                    var value = formValues[key].value
                    if (name.indexOf('[]') < 0) {
                        item[name] = value;
                    } else {
                        name = name.replace('[]', '');
                        if (typeof item[name] === 'undefined') {
                            item[name] = [];
                        }
                        item[name].push(value);
                    }
                }
                return item;
            };

            function Address() {
                var args = arguments[0];
                if (!args.hasOwnProperty('id') &&
                    !args.hasOwnProperty('zipcode') &&
                    !args.hasOwnProperty('street') &&
                    !args.hasOwnProperty('number') &&
                    !args.hasOwnProperty('city') &&
                    !args.hasOwnProperty('state') &&
                    !args.hasOwnProperty('neighborhood')) {
                    this.valid = false;
                    return;
                }
                this.id = parseInt(args.id);
                this.zipcode = args.zipcode;
                this.street = args.street;
                this.number = args.number;
                this.city = args.city;
                this.state = args.state;
                this.neighborhood = args.neighborhood;
                this.complement = (args.complement != undefined) ? args.complement : '';
                this.valid = true;
            }

            function Customer() {
                var args = arguments[0];
                if (!args.hasOwnProperty('id') &&
                    !args.hasOwnProperty('name') &&
                    !args.hasOwnProperty('telephone')) {
                    this.valid = false;
                    return;
                }
                var _self = this;
                this.id = parseInt(args.id);
                this.name = args.name;
                this.telephone = args.telephone;
                this.addresses = [];
                if (args.hasOwnProperty('addresses') && jQuery.isArray(args.addresses)) {
                    args.addresses.forEach(function (address) {
                        _self.addresses.push(new Address(address))
                    });
                }
                this.valid = true;
            }

            function CartItem() {
                var args = arguments[0];
                if (!args.hasOwnProperty('id') &&
                    !args.hasOwnProperty('name') &&
                    !args.hasOwnProperty('price') &&
                    !args.hasOwnProperty('quantity') &&
                    !args.hasOwnProperty('image_url')) {
                    this.valid = false;
                    return;
                }
                this.id = parseInt(args.id);
                this.name = args.name;
                this.price = parseFloat(args.price);
                this.quantity = parseInt(args.quantity);
                this.image_url = args.image_url;
                this.description = (args.description != undefined) ? args.description : '';
                this.observation = (args.observation != undefined) ? args.observation : '';
                this.valid = true;
            }

            var cart = function () {
                var items = @json(old('items', []));
                var discount = 0;
                var subTotal = 0;
                var total = 0;
                var shippingAmount = 0;
                var cashAmount = 0;
                var backChange = 0;
                var customer = new Customer({});
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
                    subTotal = items.reduce(function (value, item) {
                        return value + (item.price * item.quantity);
                    }, 0);
                    if ((subTotal + shippingAmount) < discount) {
                        discount = 0.0;
                    }
                    total = (subTotal + shippingAmount) - discount;

                    if ((cashAmount - total) > 0) {
                        backChange = (cashAmount - total);
                    } else {
                        backChange = 0;
                        cashAmount = total;
                    }

                };

                var _itemsQty = function () {
                    return items.reduce(function (countObj, item) {
                        if (typeof countObj[item.id] == 'undefined') {
                            countObj[item.id] = 0;
                        }
                        countObj[item.id] += 1;

                        return countObj;
                    }, {});
                };

                var _htmlItems = function () {
                    if (!_hasItems()) {
                        return '<div class="alert alert-danger" role="alert">{{__('cart empty')}}</div>';
                    }
                    return items.reduce(function (html, item, i) {
                        return html + '<a name="cart-item' + item.id + '"></a>\n' +
                            '<input type="hidden" name="items[' + i + '][product_id]" value="' + item.id + '">\n' +
                            '<input type="hidden" name="items[' + i + '][name]" value="' + item.name + '">\n' +
                            '<input type="hidden" name="items[' + i + '][image_url]" value="' + item.image_url + '">\n' +
                            '<input type="hidden" name="items[' + i + '][quantity]" value="' + item.quantity + '">\n' +
                            '<input type="hidden" name="items[' + i + '][price]" value="' + item.price + '">\n' +
                            '<input type="hidden" name="items[' + i + '][description]" value="' + item.description + '">\n' +
                            '<input type="hidden" name="items[' + i + '][observation]" value="' + item.observation + '">\n' +
                            '<div class="card mt-3">\n' +
                            '  <div class="card-body position-relative p-2">\n' +
                            '    <div class="row">\n' +
                            '      <div class="col-md-4">\n' +
                            '        <img src="' + item.image_url + '" class="card-img" alt="' + item.name + '">\n' +
                            '      </div>\n' +
                            '      <div class="col-md-8">\n' +
                            '        <h5 class="card-title">' + item.name + '</h5>\n' +
                            '      </div>\n' +
                            '    </div>\n' +
                            '    <div class="row">\n' +
                            '      <div class="col-md-12">\n' +
                            '        <p class="card-text text-center mb-0">' + item.quantity + 'x' + _formatCurrency(item.price) + '</p>\n' +
                            '        <p class="card-text mb-0"><small class="text-muted">' + item.description + '</small></p>\n' +
                            '        <p class="card-text"><small class="text-muted">' + item.observation + '</small></p>\n' +
                            '      </div>\n' +
                            '    </div>\n' +
                            '    <button class="btn btn-outline-danger btn-remove-cart" data-id="' + i + '"><i class="far fa-trash-alt"></i></button>\n' +
                            '  </div>\n' +
                            '</div>\n';
                    }, '');
                };
                var _toHtml = function () {
                    _totalItems();
                    // $('#cart-actions').toggleClass('d-none', !_hasItems());
                    $('#subtotal').val(_formatCurrency(subTotal));
                    $('#discount').val(_formatCurrency(discount));
                    $('#shipping-amount').val(_formatCurrency(shippingAmount));
                    $('#cash-amount').val(_formatCurrency(cashAmount));
                    $('#back-change').val(_formatCurrency(backChange));
                    $('#total').val(_formatCurrency(total));
                    $('#cart-items').html(_htmlItems());
                    $('.has-payment-in-cash')
                        .toggleClass('d-none', $('#payment-method').val() !== methodInCash);
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
                    },
                    setDiscountShippingAmountCashAmount: function (tmpDiscount, tmpShippingValue, tmpCashValue) {
                        tmpDiscount = (parseFloat(tmpDiscount) / 100);
                        tmpShippingValue = (parseFloat(tmpShippingValue) / 100);
                        tmpCashValue = (parseFloat(tmpCashValue) / 100);
                        if (tmpDiscount !== discount) {
                            tmpCashValue = 0;
                        }
                        discount = tmpDiscount;
                        shippingAmount = tmpShippingValue;
                        cashAmount = tmpCashValue;
                        this.toHtml();
                        if (tmpCashValue > cashAmount) {
                            myAlert('{{__('It was not possible to calculate change.')}}')
                        }
                        if (tmpDiscount > discount) {
                            myAlert('{{__('The discount could not be applied.')}}')
                        }
                    },
                    setCashAmount: function (value) {
                        cashAmount = parseFloat(value);
                        this.toHtml();
                    },
                    setCustomer: function (tmpCustomer, addressId) {
                        customer = tmpCustomer;
                        $('.has-customer').toggleClass('d-none', !customer.valid);
                        if (!customer.valid) {
                            return '';
                        }

                        var $customerId = $('#customer-id');
                        var $customerName = $('#customer-name');
                        var $customerAddress = $('#customer-address');

                        $customerId.val((customer.id) ? customer.id : '');
                        $customerName.val((customer.id) ? customer.name : '');
                        $customerAddress.html('');
                        customer.addresses.forEach(function (address) {
                            var text = address.street +
                                ' ' + address.number +
                                ' ' + address.complement;
                            $('<option data-zipcode="' + address.zipcode + '">')
                                .val(address.id)
                                .prop('selected', (address.id === addressId))
                                .text(text)
                                .appendTo($customerAddress);
                        });

                        $('<option>')
                            .val(0)
                            .prop('selected', false)
                            .text('{{__('Add New')}}')
                            .appendTo($customerAddress);
                    },
                    getCustomer: function () {
                        return customer
                    },
                    toHtml: _toHtml
                }
            }();

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
            $('body').on('submit', '.add-to-cart', function (e) {
                e.preventDefault();
                var item = formFieldsToObject($(this));
                var description = [];
                if (item.hasOwnProperty('variation')) {
                    for (var key in item.variation) {
                        var variation = getVariation(item.variation[key]);
                        if (variation) {
                            description.push(variation.name);
                        }
                    }
                }
                item['description'] = description.join(', ');
                cart.add(item);
                cart.setCashAmount(0);
            }).on('click', '.btn-remove-cart', function (e) {
                e.preventDefault();
                var position = $(this).data('id');
                cart.remove(position);
                cart.setCashAmount(0);
            }).on('change', '#payment-method', function (e) {
                e.preventDefault();
                $('#save-order').prop('disabled', !this.value);
                cart.setCashAmount(0);
            }).on('blur', '#discount, #shipping-amount, #cash-amount', function (e) {
                e.preventDefault();
                var discount = $('#discount').cleanVal();
                var shippingAmount = $('#shipping-amount').cleanVal();
                var cashAmount = $('#cash-amount').cleanVal();
                cart.setDiscountShippingAmountCashAmount(discount, shippingAmount, cashAmount);
            }).on('click', '.btn-new-customer', function (e) {
                e.preventDefault();
                $customerAutoComplete.autocomplete('hide');
                $addressModal.find('form').attr('action', defaultAction);
                $addressModal.find('input[name=telephone]').val($customerAutoComplete.val());
                showModal($customerModal, '{{ __('Add New') }}');
            }).on('change', '#customer-address', function (e) {
                var action = defaultAction + '/' + cart.getCustomer().id + '/addresses';
                $customerAutoComplete.autocomplete('hide');
                $addressModal.find('form').attr('action', action)
                if (this.value < 1) {
                    showModal($addressModal, '{{ __('Add New') }}');
                }
            }).on('click', '#label-customer-address', function (e) {
                var zipcode = $('#customer-address option:selected').data('zipcode');
                if (zipcode) {
                    window.open(mapsUrl(zipcode), 'new');
                } else {
                    myAlert('{{__('Select an address.')}}');
                }
            });


            $('.category-filters input[type=radio]').on('change', function () {
                @foreach($categories as $category)
                $('.category-{{$category->id}}').addClass('d-none');
                @endforeach
                if (!this.value) {
                    $('.product-card.d-none').removeClass('d-none');
                } else {
                    $('.' + this.value).removeClass('d-none');
                }
            });
            $customerModal.on('saveSuccessEvent', function (e, response) {
                cart.setCustomer(new Customer(response.data));
                myAlert(response.message);
                $customerModal.modal('hide');
            }).on('saveErrorEvent', function (e, response) {
                showModalErrors(response);
            });
            $addressModal.on('saveSuccessEvent', function (e, response) {
                var address = new Address(response.data);
                if (address.valid) {
                    cart.getCustomer().addresses.push(address);
                    cart.setCustomer(cart.getCustomer(), address.id);
                    myAlert(response.message);
                } else {
                    myAlert('bad!');
                }
                $addressModal.modal('hide');
            }).on('saveErrorEvent', function (e, response) {
                showModalErrors(response);
            });
            $customerAutoComplete.autocomplete({
                paramName: 'q',
                ajaxSettings: {
                    contentType: 'application/json',
                },
                serviceUrl: '{{route('users.autocomplete')}}',
                deferRequestBy: 1000,
                minChars: 3,
                autoSelectFirst: false,
                showNoSuggestionNotice: true,
                noSuggestionNotice: '<a class="btn btn-block btn-outline-secondary btn-new-customer">{{__('Add New')}}</a>',
                transformResult: function (response) {
                    if (typeof response === 'string') {
                        response = JSON.parse(response)
                    }
                    return {
                        suggestions: $.map(response.data, function (dataItem) {
                            return {
                                value: dataItem.telephone + ' - ' + dataItem.name,
                                data: dataItem
                            };
                        })
                    };
                },
                onSearchComplete: function (query, suggestions) {
                    if (suggestions.length < 1) {
                        cart.setCustomer(new Customer({}));
                    }
                },
                onSelect: function (suggestion) {
                    cart.setCustomer(new Customer(suggestion.data));
                }
            });

        });
    </script>
@endsection
