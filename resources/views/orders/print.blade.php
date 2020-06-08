{{__('Products')}}:
@foreach ($order->items as $item)
{{$item->name}}
@if($item->description)({{$item->description}})
@endif
@if($item->observation){{$item->observation}}
@endif
@endforeach

{{__('Customer')}}
{{$order->customer_name}}
{{__('Telephone')}}: {{$order->customer_telephone}}

{{__('Payment')}}
{{__('Subtotal')}}: {{$order->subtotal_formated}}
{{__('Shipping Amount')}}: {{$order->shipping_amount_formated}}
{{__('Discount')}}: {{$order->discount_formated}}
{{__('Additional Amount')}}: {{$order->additional_amount_formated}}
{{__('Amount')}}: {{$order->amount_formated}}
{{__($order->payment_method)}}@if($order->cash_amount > 0): {{$order->cash_amount_formated}}
@endif
@if($order->back_change > 0)
Troco: {{$order->back_change_formated}}
@endif

{{__('Deliveryman')}}
{{$order->deliveryman_name}}
@if($order->deliveryman_telephone){{__('Telephone')}}: {{$order->deliveryman_telephone}}
@endif

@if($order->address_id)
{{__('Address')}}
{{$order->address_street}} {{$order->address_number}}
@if($order->address_complement){{$order->address_complement}}
@endif
{{$order->address_neighborhood}} {{$order->address_city}}/{{$order->address_state}}
{{$order->address_zipcode}}
@endif
