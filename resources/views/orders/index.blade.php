@extends('layouts.app')
@section('css')
    <link href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Orders') }}</li>
    </ol>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="mt-2">{{ __('Orders') }}</div>
                            <div class="ml-auto">
                                <a class="btn btn-success" id="new-entity" href="{{route('orders.create')}}">{{__('Add New')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success d-none" role="alert" id="msg"></div>
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th width="5%">{{__('Id')}}</th>
                                <th width="8%">{{__('Created At')}}</th>
                                <th width="8%">{{__('Total')}}</th>
                                <th width="15%">{{__('Customer')}}</th>
                                <th width="8%">{{__('Telephone')}}</th>
                                <th width="28%">{{__('Address')}}</th>
                                <th width="8%">{{__('Status')}}</th>
                                <th width="20%">{{__('Action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var actionUrl = '{{ route('orders.index') }}';
            var table = $('.data-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json'
                },
                order: [[ 0, 'desc']],
                searchDelay: 1000,
                processing: true,
                serverSide: true,
                ajax: actionUrl,
                columns: [
                    {data: 'id'},
                    {data: 'created_at'},
                    {data: 'total_formated', name: 'total'},
                    {data: 'customer_name'},
                    {data: 'customer_telephone'},
                    {
                        data: 'address_street', name: 'address', orderable: false, searchable: false, render: function (data, type, row) {
                            return (type === 'display') ? (
                                row.address_street + ' ' + row.address_number + ' ' + row.address_complement + '<br/>' +
                                row.address_neighborhood + ' ' + row.address_city + '/'  + row.address_state + '<br/>' +
                                row.address_zipcode
                            ) : data;
                        }
                    },
                    {data: 'status'},
                    {
                        data: 'id', name: 'action', orderable: false, searchable: false, render: function (data, type, row) {
                            var statusNotPermited = ['{{__('canceled')}}','{{__('complete')}}'];

                            return (type === 'display') ? (
                                ((statusNotPermited.concat('{{__('processing')}}').indexOf(row.status) >= 0) ? '' :
                                '<a class="btn btn-status btn-outline-info" title="{{ __('processing') }}" data-id="' + data + '" href="' + actionUrl + '/' + data + '/processing">' +
                                    '<i class="fas fa-tasks"></i>' +
                                '</a>\n') +
                                ((statusNotPermited.concat('{{__('delivery')}}').indexOf(row.status) >= 0) ? '' :
                                '<a class="btn btn-status btn-outline-success" title="{{ __('delivery') }}" data-id="' + data + '" href="' + actionUrl + '/' + data + '/delivery">' +
                                '   <i class="fas fa-motorcycle"></i>' +
                                '</a>\n') +
                                ((statusNotPermited.indexOf(row.status) >= 0) ? '' :
                                '<a class="btn btn-status btn-outline-success" title="{{ __('complete') }}" data-id="' + data + '" href="' + actionUrl + '/' + data + '/complete">' +
                                '   <i class="fas fa-check"></i>' +
                                '</a>\n') +
                                ((statusNotPermited.indexOf(row.status) >= 0) ? '' :
                                '<a class="btn btn-status btn-outline-danger" title="{{ __('canceled') }}" data-id="' + data + '" href="' + actionUrl + '/' + data + '/canceled">' +
                                    '<i class="far fa-trash-alt"></i>' +
                                '</a>\n')
                            ) : data;
                        }
                    },
                ]
            });
            $('body').on('click', '.btn-status', function (e) {
                e.preventDefault();
                var $this = $(this);
                if (!confirm('{{ __('Are you sure you want to change the status to') }} (' +$this.attr('title')+ ')?')) {
                    return '';
                }
                $.ajax({
                    type: 'GET',
                    url: $this.attr('href'),
                    success: function (data) {
                        myAlert(data.message);
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.message);
                    }
                });
            });
        });
    </script>
@endsection
