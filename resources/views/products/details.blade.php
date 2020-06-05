@extends('layouts.blank')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">{{$product->name}} - {{$product->price_formated}}</h1>
                <p class="lead">{{$product->description}}</p>
            </div>
        </div>
        @if($product->variations)
            <div class="row justify-content-center">
                @foreach($product->variations as $variation)
                    <?php /** @var  \App\Variation $variation */?>
                    <div class="card-deck mb-3 text-center col-md-3">
                        <div class="card mb-4 shadow-sm">

                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{$variation->name}}</h4>
                            </div>
                            <div class="card-body p-1">
                                <img class="rounded" src="{{$variation->image_url}}"/>
                                <p class="text-muted mt-2">{{$variation->description}}</p>
                                @if($variation->items)
                                    <ul class="list-unstyled mb-1">
                                        @foreach($variation->items as $item)
                                            <li>{{$item->name}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
