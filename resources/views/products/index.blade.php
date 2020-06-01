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
        <li class="breadcrumb-item active" aria-current="page">{{ __('Products') }}</li>
    </ol>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="mt-2">{{ __('Products') }}</div>
                            <div class="ml-auto">
                                <a class="btn btn-success" id="new-entity" href="{{route('products.create')}}">{{__('Add New')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success d-none" role="alert" id="msg"></div>
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th width="5%">{{__('Id')}}</th>
                                <th width="35%">{{__('Category')}}</th>
                                <th width="30%">{{__('Name')}}</th>
                                <th width="30%">{{__('Action')}}</th>
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
            var actionUrl = '{{ route('products.index') }}';
            var msgTimeout;
            function showMsg(message) {
                var $msg = $('#msg');
                $msg.removeClass('d-none').html(message);
                clearTimeout(msgTimeout);
                msgTimeout = setTimeout(function () {
                    $msg.addClass('d-none');
                }, 5000);
            }
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
                    {data: 'category'},
                    {data: 'name'},
                    {
                        data: 'id', name: 'action', orderable: false, searchable: false, render: function (data, type) {
                            return (type === 'display') ? (
                                '<a class="btn btn-info show-entity" title="{{ __('Show') }}" data-id="' + data + '" href="' + actionUrl + '/' + data + '">' +
                                    '<i class="far fa-eye"></i>' +
                                '</a> ' +
                                '<a class="btn btn-success edit-entity" title="{{ __('Edit') }}" data-id="' + data + '" href="' + actionUrl + '/' + data + '/edit">' +
                                    '<i class="far fa-edit"></i>' +
                                '</a> ' +
                                '<a class="btn btn-danger delete-entity" title="{{ __('Delete') }}" data-id="' + data + '">' +
                                    '<i class="far fa-trash-alt"></i>' +
                                '</a>'
                            ) : data;
                        }
                    },
                ]
            });
            $('body').on('click', '.delete-entity', function () {
                var id = $(this).data('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                if (!confirm('{{ __('Are You sure want to delete?') }}')) {
                    return '';
                }
                $.ajax({
                    type: 'DELETE',
                    url: actionUrl + '/' + id,
                    data: {
                        id: id,
                        _token: token,
                    },
                    success: function (data) {
                        showMsg(data);
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
