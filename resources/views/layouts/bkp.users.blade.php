@extends('layouts.app')
@section('css')
    <link href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="mt-2">{{ __('Users') }}</div>
                            <div class="ml-auto">
                                <a class="btn btn-success" id="new-entity" data-toggle="modal">{{__('Add New')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success d-none" role="alert" id="msg"></div>
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th width="5%">{{__('Id')}}</th>
                                <th width="30%">{{__('Name')}}</th>
                                <th width="20%">{{__('Telephone')}}</th>
                                <th width="15%">{{__('Profile')}}</th>
                                <th width="30%">{{__('Action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add and Edit customer modal -->
    <div class="modal fade" id="crud-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="form-save" method="POST">
                        @csrf

                        @include('users._form')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var $modal = $('#crud-modal');
            var msgTimeout;
            var clearData = {id: '', name: '', email: '', telephone: '', is_admin: 0};
            var actionUrl = '{{ route('users.index') }}';
            var userProfiles = @json(\App\User::types());
            function showModal(data, readOnly, title) {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').find('strong').html('');
                $('#entity_id').prop('readonly', readOnly).val(data.id);
                $('#name').prop('readonly', readOnly).val(data.name);
                $('#email').prop('readonly', readOnly).val(data.email);
                $('#telephone').prop('readonly', readOnly).val(data.telephone);
                $('#is_admin').prop('disabled', readOnly).val(data.is_admin);
                $modal.find('button[type=submit]').toggleClass('d-none', readOnly);
                $modal.find('.modal-title').html(title);
                $modal.modal('show');
            }

            function showData(entityId, readOnly) {
                $.get(actionUrl +'/' + entityId, function (data) {
                    showModal(data, readOnly, (readOnly) ? '{{ __('Show Data') }}' : '{{ __('Edit Data') }}');
                });
            }

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
                searchDelay: 1000,
                processing: true,
                serverSide: true,
                ajax: actionUrl,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'telephone', name: 'telephone'},
                    {
                        data: 'is_admin', name: 'is_admin', render: function (data, type) {
                            return (type === 'display') ? (userProfiles[parseInt(data)] ? userProfiles[parseInt(data)] : data) : data
                        }
                    },
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

            /* When click New customer button */
            $('#new-entity').click(function () {
                showModal(clearData, false, '{{ __('Add New') }}');
            });

            /* Edit customer */
            $('body').on('click', '.edit-entity', function (e) {
                e.preventDefault();
                showData($(this).data('id'), false);
            }).on('click', '.show-entity', function (e) {
                e.preventDefault();
                showData($(this).data('id'), true);
            }).on('click', '.delete-entity', function (e) {
                e.preventDefault();
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
            }).on('submit', '#form-save', function (e) {
                e.preventDefault();
                var $this = $(this);
                var entityId = $this.find('input[name="entity_id"]').val();
                var data = $this.serialize();
                var url = actionUrl + ((entityId) ? '/' + entityId : '');
                $.ajax({
                    type: (entityId) ? 'PUT' : 'POST',
                    url: url,
                    data: data,
                    success: function (data) {
                        showMsg(data);
                        $modal.modal('hide');
                        table.ajax.reload();
                    },
                    error: function (data) {
                        var errors = JSON.parse(data.responseText);
                        if (!errors || !errors.hasOwnProperty('errors')) {
                            return '';
                        }
                        for (var error in errors.errors) {
                            $('#' + error).addClass('is-invalid');
                            $('#invalid-' + error).find('strong')
                                .html(errors.errors[error]);
                        }
                    }
                });
                return false;
            });

        });
    </script>
@endsection
