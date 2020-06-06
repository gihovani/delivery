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
                                <a class="btn btn-success" id="new-entity"
                                   href="{{route('orders.create')}}">{{__('Add New')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success d-none" role="alert" id="msg"></div>
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th width="5%">{{__('Id')}}</th>
                                <th width="12%">{{__('Created At')}}</th>
                                <th width="13%">{{__('Expected At')}}</th>
                                <th width="10%">{{__('Amount')}}</th>
                                <th width="30%">{{__('Customer')}}</th>
                                <th width="10%">{{__('Status')}}</th>
                                <th width="20%">{{__('Action')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('orders.modals.status-modal', ['modalId' => 'status-modal'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var actionUrl = '{{ route('orders.index') }}';
            var $statusModal = $('#status-modal');
            var table = $('.data-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json'
                },
                order: [[1, 'desc']],
                searchDelay: 1000,
                processing: true,
                serverSide: true,
                ajax: actionUrl,
                columns: [
                    {
                        orderable: false,
                        data: null,
                        defaultContent: '<button class="btn btn-show"><i class="far fa-plus-square"></i></button>'
                    },
                    {data: 'created_at'},
                    {data: 'expected_at'},
                    {data: 'amount_formated', name: 'amount'},
                    {
                        data: 'customer_name', render: function (data, type, row) {
                            if (type === 'display') {
                                return data + (
                                    !row.customer_telephone ? '' : '<br/>' + whatsAppLink(row.customer_telephone)
                                ) + '<br/>' + (!row.address_id ? row.deliveryman_name : (
                                        row.address_street + ' ' + row.address_number + ' ' + row.address_complement + '<br/>' +
                                        row.address_neighborhood + ' ' + row.address_city + '/' + row.address_state + '<br/>' +
                                        row.address_zipcode
                                    )
                                );
                            }
                            return data;
                        }
                    },
                    {
                        data: 'status', render: function (data, type, row) {
                            if (type === 'display') {
                                return data + (
                                    !row.is_late ? '' :
                                    '<br/><span class="badge badge-warning">'+row.is_late+'</span>'
                                )
                            }

                            return data;
                        }
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            var statusNotPermited = ['{{__('canceled')}}', '{{__('complete')}}'];

                            return (type === 'display') ? (
                                ((statusNotPermited.concat('{{__('processing')}}').indexOf(row.status) >= 0) ? '' :
                                    '<a class="btn btn-status btn-outline-info" title="{{ __('processing') }}" data-deliveryman_id="' + row.deliveryman_id + '" href="' + actionUrl + '/' + data + '/processing">' +
                                    '<i class="fas fa-tasks"></i>' +
                                    '</a>\n') +
                                ((statusNotPermited.concat('{{__('delivery')}}').indexOf(row.status) >= 0) ? '' :
                                    '<a class="btn btn-status btn-outline-success" title="{{ __('delivery') }}" data-deliveryman_id="' + row.deliveryman_id + '" href="' + actionUrl + '/' + data + '/delivery">' +
                                    '   <i class="fas fa-motorcycle"></i>' +
                                    '</a>\n') +
                                ((statusNotPermited.indexOf(row.status) >= 0) ? '' :
                                    '<a class="btn btn-status btn-outline-success" title="{{ __('complete') }}" data-deliveryman_id="' + row.deliveryman_id + '" href="' + actionUrl + '/' + data + '/complete">' +
                                    '   <i class="fas fa-check"></i>' +
                                    '</a>\n') +
                                ((statusNotPermited.indexOf(row.status) >= 0) ? '' :
                                    '<a class="btn btn-status btn-outline-danger" title="{{ __('canceled') }}" data-deliveryman_id="' + row.deliveryman_id + '" href="' + actionUrl + '/' + data + '/canceled">' +
                                    '<i class="far fa-trash-alt"></i>' +
                                    '</a>\n')
                            ) : data;
                        }
                    },
                ]
            });

            var formatItem = function (html, item) {
                return html + '<li>' + parseInt(item.quantity) + 'x ' + item.name +
                    (item.description ? '(' + item.description + ')' : '') +
                    (item.observation ? '[' + item.observation + ']' : '') + '</li>\n';
            };

            var formatOrder = function (data) {
                if (!data) {
                    return '';
                }
                var items = (data.items) ? data.items.reduce(formatItem, '') : '';
                return '<table class="table table-dark">\n' +
                    '   <tr>\n' +
                    '       <th width="20%">{{__('Order')}}:</th>\n' +
                    '       <td>\n' + data.id +
                    '           <a href="' + actionUrl + '/' + data.id + '/print" target="_blank"><i class="fas fa-print"></i> {{__('Print')}}</a>' +
                    '       </td>\n' +
                    '   </tr>\n' +
                    '   <tr>\n' +
                    '       <th>{{__('Customer')}}:</th>\n' +
                    '       <td>\n' +
                    data.customer_name +
                    (!data.customer_telephone ? '' : ' - ' + whatsAppLink(data.customer_telephone)) +
                    '       </td>\n' +
                    '   </tr>\n' +
                    '   <tr>\n' +
                    '       <th>{{__('Payment Method')}}:</th>\n' +
                    '       <td>\n' +
                    '       <label>{{__('Subtotal')}}</label>: ' + data.subtotal_formated + '<br/>' +
                    '       <label>{{__('Shipping Amount')}}</label>: ' + data.shipping_amount_formated + '<br/>' +
                    '       <label>{{__('Discount')}}</label>: ' + data.discount_formated + '<br/>' +
                    '       <label>{{__('Additional Amount')}}</label>: ' + data.additional_amount_formated + '<br/>' +
                    '       <label>{{__('Amount')}}</label>: ' + data.amount_formated + '<br/>' +
                    '       <label>{{__('Payment Method')}}</label>: ' + data.payment_method +
                    (data.cash_amount ? ' ' + data.cash_amount_formated : '') +
                    (data.back_change ? ' - {{__('Back Change')}}: ' + data.back_change_formated : '') +
                    '       </td>\n' +
                    '   </tr>\n' +
                    '   <tr>\n' +
                    '       <th>{{__('Deliveryman')}}:</th>\n' +
                    '       <td>\n' +
                    data.deliveryman_name +
                    (!data.deliveryman_telephone ? '' : ' - ' + whatsAppLink(data.deliveryman_telephone)) +
                    '       </td>\n' +
                    '   </tr>\n' +
                    (!data.deliveryman_id ? '' :
                        '   <tr>\n' +
                        '       <th>{{__('Address')}}:</th>\n' +
                        '       <td>\n' +
                        '           <a target="_blank" href="' + mapsUrl(data.address_zipcode) + '"><i class="fas fa-map-marked-alt"></i> ' +
                        data.address_street + ' ' + data.address_number + ' ' + (data.address_complement ? data.address_complement : '') + '<br/>' +
                        data.address_neighborhood + ' ' + data.address_city + '/' + data.address_state + '<br/>' +
                        data.address_zipcode +
                        '           </a>' +
                        '       </td>\n' +
                        '   </tr>\n') +
                    '   <tr>\n' +
                    '      <th>{{__('Products')}}:</th>\n' +
                    '      <td><ul>' + items + '</ul></td>\n' +
                    '   </tr>\n' +
                    '</table>\n';
            };

            $('body').on('click', '.btn-show', function () {
                var $this = $(this);
                var tr = $this.closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    $this.find('i').addClass('fa-plus-square').removeClass('fa-minus-square');
                } else {
                    // Open this row
                    if (row.child() && row.child().length) {
                        row.child.show();
                    } else {
                        row.child(formatOrder(row.data()), 'p-0').show();
                    }
                    $this.find('i').removeClass('fa-plus-square').addClass('fa-minus-square');
                }
            }).on('click', '.btn-status', function (e) {
                e.preventDefault();
                var $this = $(this);
                var $form = $statusModal.find('form');
                var action = $this.attr('href');
                var deliveryman_id = $this.data('deliveryman_id');
                $form.attr('action', action);
                $form.find('select[name=deliveryman_id]').val(deliveryman_id ?? 0)
                showModal($statusModal, '{{ __('Are you sure you want to change the status to') }} (' + $this.attr('title') + ')?');
            });
            $statusModal.on('saveSuccessEvent', function (e, response) {
                myAlert(response.message);
                $statusModal.modal('hide');
                table.ajax.reload();
            }).on('saveErrorEvent', function (e, response) {
                showModalErrors(response);
            });
        });
    </script>
@endsection
