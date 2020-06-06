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
                                <div data-remote="{{route('products.details', $product)}}" data-toggle="modal"
                                     data-target="#product-modal">
                                    <div class="product-img-area"
                                         style="background-image: url('{{$product->image_url}}')">
                                        @for ($i=0;$i<$product->pieces;$i++)
                                            <div class="bg-{{$i}} variation_{{$product->id}}_{{$i}}"></div>
                                        @endfor
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$product->name}}</h5>
                                        <p class="card-text">{{$product->description}}</p>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @for ($i=0;$i<$product->pieces;$i++)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                {!! Form::label('variation_'.$product->id, __('Variation').' '.($i+1), ['class' => 'input-group-text']) !!}
                                            </div>
                                            {!! Form::select('variation[]', $product->getVariationToOptionList(true),'',['required' => true, 'data-position' => $i, 'data-pieces' => $product->pieces, 'data-id' => 'variation_'.$product->id.'_'.$i, 'class' => 'variation-select custom-select']) !!}
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
                        {!! Form::text('customer-autocomplete', '(48) ', ['required' => true, 'class' => 'form-control input-telephone', 'id' => 'customer-autocomplete']) !!}
                    </div>

                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('deliveryman-id', __('Deliveryman'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::select('deliveryman_id', \App\User::getDeliveryman(), '', ['required' => true, 'class' => 'form-control', 'id' => 'deliveryman-id']) !!}
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
                        {!! Form::text('discount', '', ['required' => true, 'class' => 'form-control cart-totalize', 'id' => 'discount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
                    </div>
                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('shipping-amount', __('Shipping Amount'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('shipping_amount', '', ['required' => true, 'readonly' => !old('deliveryman_id'), 'class' => 'form-control cart-totalize', 'id' => 'shipping-amount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
                    </div>
                    <div class="input-group has-customer d-none">
                        <div class="input-group-prepend">
                            {!! Form::label('additional-amount', __('Additional Amount'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('additional_amount', '', ['required' => true, 'class' => 'form-control cart-totalize', 'id' => 'additional-amount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            {!! Form::label('amount', __('Amount'), ['class' => 'input-group-text']) !!}
                        </div>
                        {!! Form::text('amount', '', ['readonly' => true, 'class' => 'form-control', 'id' => 'amount']) !!}
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
                        {!! Form::text('cash_amount', '', ['required' => true, 'class' => 'form-control cart-totalize', 'id' => 'cash-amount', 'data-mask' => '#.##0,00', 'data-mask-reverse' => 'true']) !!}
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

    @include('orders.modals.user-modal', ['modalId' => 'customer-modal'])
    @include('orders.modals.address-modal', ['modalId' => 'address-modal'])
    @include('orders.modals.products-modal', ['modalId' => 'product-modal'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var variations = @json($variations);
            var $customerModal = $('#customer-modal');
            var $addressModal = $('#address-modal');
            var $customerAutoComplete = $('#customer-autocomplete');
            var methodInCash = '{{\App\Order::METHOD_IN_CASH}}';
            var defaultAction = '{{route('users.store')}}';

            var cart = function () {
                var items = @json(old('items', []));
                var discount = 0;
                var subTotal = 0;
                var amount = 0;
                var additionalAmount = 0;
                var shippingAmount = 0;
                var cashAmount = 0;
                var backChange = 0;
                var customer = new Customer({});
                var address = new Address({});

                var _hasItems = function () {
                    return (items.length > 0);
                };

                var _totalize = function () {
                    subTotal = items.reduce(function (value, item) {
                        return value + item.getTotal();
                    }, 0);
                    amount = (subTotal + shippingAmount + additionalAmount);
                    if (amount < discount) {
                        discount = 0.0;
                    }
                    amount = amount - discount;

                    if ((cashAmount - amount) > 0) {
                        backChange = (cashAmount - amount);
                    } else {
                        backChange = 0;
                        cashAmount = amount;
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
                        return html + '<div class="position-relative">' +
                            item +
                            '<input type="hidden" name="items[' + i + '][product_id]" value="' + self.id + '">\n' +
                            '<input type="hidden" name="items[' + i + '][name]" value="' + self.name + '">\n' +
                            '<input type="hidden" name="items[' + i + '][image_url]" value="' + self.image_url + '">\n' +
                            '<input type="hidden" name="items[' + i + '][quantity]" value="' + self.quantity + '">\n' +
                            '<input type="hidden" name="items[' + i + '][price]" value="' + self.price + '">\n' +
                            '<input type="hidden" name="items[' + i + '][description]" value="' + self.description + '">\n' +
                            '<input type="hidden" name="items[' + i + '][observation]" value="' + self.observation + '">\n' +
                            '<button class="btn btn-outline-danger btn-remove-cart" data-id="' + i + '"><i class="far fa-trash-alt"></i></button>\n' +
                            '</div>';
                    }, '');
                };
                var _setFormValues = function () {
                    var paymentMethod = $('#payment-method').val();
                    _totalize();
                    $('#subtotal').val(formatCurrency(subTotal));
                    $('#discount').val(formatCurrency(discount));
                    $('#shipping-amount').val(formatCurrency(shippingAmount));
                    $('#additional-amount').val(formatCurrency(additionalAmount));
                    $('#cash-amount').val(formatCurrency(cashAmount));
                    $('#back-change').val(formatCurrency(backChange));
                    $('#amount').val(formatCurrency(amount));
                    $('#cart-items').html(_htmlItems());
                    $('.has-payment-in-cash')
                        .toggleClass('d-none', paymentMethod !== methodInCash);
                    $('#save-order').prop('disabled', (paymentMethod === '0' || !_hasItems()));
                };

                var _htmlCustomer = function () {
                    $('.has-customer').toggleClass('d-none', !customer.valid);
                    if (!customer.valid) {
                        return '';
                    }

                    var $customerId = $('#customer-id');
                    var $customerName = $('#customer-name');
                    var $customerAddress = $('#customer-address');

                    $customerId.val(customer.id);
                    $customerName.val(customer.name);
                    $customerAddress.html('');
                    customer.addresses.forEach(function (currentAddr) {
                        $('<option>')
                            .val(currentAddr.id)
                            .prop('selected', (currentAddr.id === address.id))
                            .text(currentAddr + (!currentAddr.complement.length ? '' : ' (' + currentAddr.complement + ')'))
                            .appendTo($customerAddress);
                    });
                    $('<option>')
                        .val(0)
                        .text('{{__('Add New')}}')
                        .appendTo($customerAddress);
                };
                _setFormValues();
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
                            location.hash = "#item" + cartItem.id;
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
                    setDiscountShippingAmountCashAmount: function (tmpDiscount, tmpShippingValue, tmpAdditionalAmount, tmpCashValue) {
                        tmpDiscount = (parseFloat(tmpDiscount) / 100);
                        tmpShippingValue = (parseFloat(tmpShippingValue) / 100);
                        tmpCashValue = (parseFloat(tmpCashValue) / 100);
                        tmpAdditionalAmount = (parseFloat(tmpAdditionalAmount) / 100);
                        if (tmpDiscount !== discount) {
                            tmpCashValue = 0;
                        }
                        discount = tmpDiscount;
                        shippingAmount = tmpShippingValue;
                        additionalAmount = tmpAdditionalAmount;
                        cashAmount = tmpCashValue;
                        _setFormValues();
                        if (tmpCashValue > cashAmount) {
                            myAlert('{{__('It was not possible to calculate change.')}}')
                        }
                        if (tmpDiscount > discount) {
                            myAlert('{{__('The discount could not be applied.')}}')
                        }
                    },
                    setCashAmount: function (value) {
                        cashAmount = parseFloat(value);
                        _setFormValues();
                    },
                    setShippingAddress: function (addr) {
                        if (!(addr && addr.valid)) {
                            addr = new Address({});
                        }
                        address = addr;
                        _htmlCustomer();
                    },
                    setCustomer: function (tmpCustomer) {
                        if (!(tmpCustomer && tmpCustomer.valid)) {
                            tmpCustomer = new Customer({});
                        }
                        customer = tmpCustomer;
                        _htmlCustomer();
                    },
                    getCustomer: function () {
                        return customer;
                    },
                    getShippingAddress: function () {
                        return address;
                    }
                }
            }();

            $('body').on('submit', '.add-to-cart', function (e) {
                e.preventDefault();
                var item = formFieldsToObject($(this));
                var description = [];
                if (item.hasOwnProperty('variation')) {
                    for (var key in item.variation) {
                        var variation = findInArrayById(variations, item.variation[key]);
                        if (variation !== null) {
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
                cart.setCashAmount(0);
            }).on('blur', '.cart-totalize', function (e) {
                e.preventDefault();
                var discount = $('#discount').cleanVal();
                var shippingAmount = $('#shipping-amount').cleanVal();
                var additionalAmount = $('#additional-amount').cleanVal();
                var cashAmount = $('#cash-amount').cleanVal();
                cart.setDiscountShippingAmountCashAmount(discount, shippingAmount, additionalAmount, cashAmount);
            }).on('click', '.btn-new-customer', function (e) {
                e.preventDefault();
                $customerAutoComplete.autocomplete('hide');
                $customerModal.find('form').attr('action', defaultAction);
                $customerModal.find('input[name=telephone]').val($customerAutoComplete.val());
                showModal($customerModal, '{{ __('Add New') }}');
            }).on('change', '#customer-address', function (e) {
                var action = defaultAction + '/' + cart.getCustomer().id + '/addresses';
                $customerAutoComplete.autocomplete('hide');
                $addressModal.find('form').attr('action', action)
                if (this.value > 0) {
                    var addr = findInArrayById(cart.getCustomer().addresses, this.value);
                    return cart.setShippingAddress(addr);
                }
                showModal($addressModal, '{{ __('Add New') }}');

            }).on('click', '#label-customer-address', function (e) {
                var addr = cart.getShippingAddress();
                if (!addr.valid || addr.zipcode === '{{App\Address::DEFAULT_ZIPCODE}}') {
                    myAlert('{{__('Select an address.')}}');
                    return;
                }
                window.open(mapsUrl(addr.getMapsUri()), 'new');
            }).on('change', '#deliveryman-id', function () {
                var $shippingAmount = $('#shipping-amount');
                $shippingAmount.prop('readonly', (this.value < 1));
                if (this.value > 0) {
                    $shippingAmount.val('0')
                        .trigger('blur');
                }
            }).on('change', '.variation-select', function () {
                var variation = findInArrayById(variations, this.value);
                if (!variation) {
                    return '';
                }

                var $this = $(this);
                var $form = $this.closest('form');
                var classBackground = ($this.data('pieces') !== 1) ? '.bg-' + $this.data('position') : '.product-img-area';
                $form.find(classBackground).css('background-image', 'url("' + variation.image_url + '")');
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
            var clearAddrOnClose = true;
            $addressModal.on('saveSuccessEvent', function (e, response) {
                var addr = new Address(response.data);
                if (addr.valid) {
                    cart.getCustomer().addresses.push(addr);
                    cart.setShippingAddress(addr);
                    myAlert(response.message);
                } else {
                    myAlert('bad!');
                }
                clearAddrOnClose = false;
                $addressModal.modal('hide');
            }).on('saveErrorEvent', function (e, response) {
                showModalErrors(response);
            }).on('show.bs.modal', function () {
                clearAddrOnClose = true;
            }).on('hide.bs.modal', function () {
                if (clearAddrOnClose) {
                    cart.setShippingAddress(null);
                }
            });
            $customerAutoComplete.autocomplete({
                paramName: 'q',
                ajaxSettings: {
                    contentType: 'application/json',
                },
                zIndex: 1,
                noCache: true,
                serviceUrl: '{{route('users.autocomplete')}}',
                deferRequestBy: 500,
                minChars: 10,
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
                                value: dataItem.telephone,
                                data: dataItem
                            };
                        })
                    };
                },
                onSearchComplete: function (query, suggestions) {
                    if (suggestions.length < 1) {
                        cart.setCustomer(null);
                    }
                },
                onSelect: function (suggestion) {
                    cart.setCustomer(new Customer(suggestion.data));
                }
            });
        });
    </script>
@endsection
