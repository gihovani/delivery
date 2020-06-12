@extends('layouts.app')
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <style>
        .chart-sparkline {
            width: 75px;
            height: 35px;
        }
    </style>
@endsection
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <form class="row" action="{{route('home')}}" method="GET">
                            {!! Form::label('start', __('Period'), ['class' => 'col-md-2 col-form-label']) !!}
                            <div class="col-md-4">
                                {!! Form::text('start', $start ?? date('d/m/Y'), ['required' => true, 'data-mask' => '00/00/0000', 'class'=>'form-control'.($errors->has('start') ? ' is-invalid' : '')]) !!}
                                <span class="invalid-feedback invalid-start" role="alert">
                                        <strong>@error('start') {{ $message }} @enderror</strong>
                                    </span>
                            </div>
                            <div class="col-md-4">
                                {!! Form::text('end', $end ?? date('d/m/Y'), ['required' => true, 'data-mask' => '00/00/0000', 'class'=>'form-control'.($errors->has('end') ? ' is-invalid' : '')]) !!}
                                <span class="invalid-feedback invalid-end" role="alert">
                                        <strong>@error('end') {{ $message }} @enderror</strong>
                                    </span>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary  btn-block">OK
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row pt-2">
                    <!-- weekly sales -->
                    <div class="col-12 col-lg-6 col-xl">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <!-- Title -->
                                        <h6 class="text-uppercase text-muted mb-2">
                                            {{__('Last :countDays Days', ['countDays' => $countDays])}}
                                        </h6>
                                        <!-- Heading -->
                                        <span class="h4 mb-0">{{$amountLast7Days}}</span>
                                        <!-- Badge -->
                                        {{--                                <span class="badge badge-soft-success mt-n1">+3.5%</span>--}}
                                    </div>
                                    <div class="col-auto">
                                        <!-- Icon -->
                                        <span class="h2 fas fa-dollar-sign text-muted mb-0"></span>
                                    </div>
                                </div> <!-- / .row -->
                            </div>
                        </div>
                    </div>

                    <!-- Orders Placed -->
                    <div class="col-12 col-lg-6 col-xl">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <!-- Title -->
                                        <h6 class="text-uppercase text-muted mb-2">
                                            {{__('Orders Placed')}}
                                        </h6>
                                        <!-- Heading -->
                                        <span class="h4 mb-0">{{$totalOrders}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Icon -->
                                        <span class="h2 fas fa-briefcase text-muted mb-0"></span>

                                    </div>
                                </div> <!-- / .row -->
                            </div>
                        </div>
                    </div>

                    <!-- Conversion Rate -->
                    <div class="col-12 col-lg-6 col-xl">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <!-- Title -->
                                        <h6 class="text-uppercase text-muted mb-2">
                                            {{__('Conversion Rate')}}
                                        </h6>

                                        <div class="row align-items-center no-gutters">
                                            <div class="col-auto">
                                                <!-- Heading -->
                                                <span class="h4 mr-2 mb-0">{{$conversionRate}}%</span>
                                            </div>
                                            <div class="col">
                                                <!-- Progress -->
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar" role="progressbar" style="width: 85%"
                                                         aria-valuenow="85" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div> <!-- / .row -->
                                    </div>
                                    <div class="col-auto">
                                        <!-- Icon -->
                                        <span class="h2 fas fa-clipboard text-muted mb-0"></span>
                                    </div>
                                </div> <!-- / .row -->
                            </div>
                        </div>

                    </div>
                    <!-- avg value -->
                    <div class="col-12 col-lg-6 col-xl">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <!-- Title -->
                                        <h6 class="text-uppercase text-muted mb-2">
                                            {{__('Avg Value')}}
                                        </h6>
                                        <!-- Heading -->
                                        <span class="h4 mb-0">{{$avgLast7Days}}</span>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Chart -->
                                        <div class="chart chart-sparkline">
                                            <canvas class="chart-canvas" id="sparklineChart"></canvas>
                                        </div>
                                    </div>
                                </div> <!-- / .row -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-12 col-xl-6">
                        <!-- Sales -->
                        <div class="card">
                            <div class="card-header">
                                <!-- Title -->
                                <h4 class="card-header-title">
                                    {{__('Sales')}}
                                </h4>
                            </div>
                            <div class="card-body">
                                <!-- Chart -->
                                <div class="chart">
                                    <canvas id="salesChart" class="chart-canvas chartjs-render-monitor"
                                            width="638" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <!-- Products -->
                        <div class="card">
                            <div class="card-header">
                                <!-- Title -->
                                <h4 class="card-header-title">
                                    {{__('Products')}}
                                </h4>
                            </div>
                            <div class="card-body">
                                <!-- Chart -->
                                <div class="chart">
                                    <canvas id="productsChart" class="chart-canvas chartjs-render-monitor"
                                            width="638" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-12 col-xl-6">
                        <!-- Payment Methods -->
                        <div class="card">
                            <div class="card-header">
                                <!-- Title -->
                                <h4 class="card-header-title">
                                    {{__('Payment Methods')}}
                                </h4>
                            </div>
                            <div class="card-body">
                                <!-- Chart -->
                                <div class="chart">
                                    <canvas id="paymentMethodsChart" class="chart-canvas chartjs-render-monitor"
                                            width="638" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-6">
                        <!-- Shipping Tax -->
                        <div class="card">
                            <div class="card-header">
                                <!-- Title -->
                                <h4 class="card-header-title">
                                    {{__('Shipping Tax')}}
                                </h4>
                            </div>
                            <div class="card-body">
                                <!-- Chart -->
                                <div class="chart">
                                    <canvas id="shippingTaxChart" class="chart-canvas chartjs-render-monitor"
                                            width="638" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var sparklineChart = function () {
                            var myChart = document.getElementById('sparklineChart');
                            if (!(typeof (Chart) !== 'undefined' && myChart)) {
                                return;
                            }
                            new Chart(myChart, {
                                type: 'line',
                                data: {
                                    labels: ['', '', '', '', '', '', ''],
                                    datasets: [{
                                        label: '',
                                        data: @json(array_values($daysValues)),
                                        fill: false,
                                        // 'color': 'blue',
                                        borderColor: '#3490dc',
                                        lineTension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false,
                                    },
                                    scales: {
                                        yAxes: [{
                                            display: false
                                        }],
                                        xAxes: [{
                                            display: false
                                        }]
                                    }
                                }
                            });
                        }();
                        var salesChart = function () {
                            var myChart = document.getElementById('salesChart');
                            if (!(typeof (Chart) !== 'undefined' && myChart)) {
                                return;
                            }
                            new Chart(myChart, {
                                type: 'bar',
                                data: {
                                    labels: @json(array_keys($daysValues)),
                                    datasets: [{
                                        data: @json(array_values($daysValues)),
                                        fill: false,
                                        // 'color': 'blue',
                                        borderColor: '#3490dc',
                                        lineTension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false,
                                    },
                                    scales: {
                                        yAxes: [{
                                            display: true
                                        }],
                                        xAxes: [{
                                            display: true
                                        }]
                                    }
                                }
                            });
                        }();
                        var productsChart = function () {
                            var myChart = document.getElementById('productsChart');
                            if (!(typeof (Chart) !== 'undefined' && myChart)) {
                                return;
                            }
                            new Chart(myChart, {
                                type: 'pie',
                                data: {
                                    labels: @json(array_keys($productsValues)),
                                    datasets: [{
                                        data: @json(array_values($productsValues)),
                                        backgroundColor: [
                                            'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'
                                        ]
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            display: false
                                        }],
                                        xAxes: [{
                                            display: false
                                        }]
                                    }
                                }
                            });
                        }();
                        var paymentMethodsChart = function () {
                            var myChart = document.getElementById('paymentMethodsChart');
                            if (!(typeof (Chart) !== 'undefined' && myChart)) {
                                return;
                            }
                            new Chart(myChart, {
                                type: 'bar',
                                data: {
                                    labels: @json(array_keys($paymentMethodValues)),
                                    fill: false,
                                    datasets: [{
                                        data: @json(array_values($paymentMethodValues)),
                                        // backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(255, 5, 186)']
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false,
                                    },
                                    scales: {
                                        yAxes: [{
                                            display: true
                                        }],
                                        xAxes: [{
                                            display: true
                                        }]
                                    }
                                }
                            });
                        }();
                        var shippingTaxChart = function () {
                            var myChart = document.getElementById('shippingTaxChart');
                            if (!(typeof (Chart) !== 'undefined' && myChart)) {
                                return;
                            }
                            new Chart(myChart, {
                                type: 'line',
                                data: {
                                    labels: @json(array_keys($shippingTaxValues)),
                                    datasets: [{
                                        label: '',
                                        data: @json(array_values($shippingTaxValues)),
                                        fill: false,
                                        // 'color': 'blue',
                                        borderColor: '#3490dc',
                                        lineTension: 0.1
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false,
                                    },
                                    scales: {
                                        yAxes: [{
                                            display: true
                                        }],
                                        xAxes: [{
                                            display: true
                                        }]
                                    }
                                }
                            });
                        }();
                    });
                    var paymentMethodValues = @json($paymentMethodValues);
                    var shippingTaxValues = @json($shippingTaxValues);
                    var productsValues = @json($productsValues);
                    var daysValues = @json($daysValues);
                </script>
            </div>
        </div>
@endsection
