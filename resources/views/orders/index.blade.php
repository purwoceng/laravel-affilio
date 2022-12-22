@extends('core.app')
@section('title', __('Orders Page'))
@push('css')
    {{-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush



@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Orders</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">List Orders</h3>
                    </div>
                </div>

                <div class="card-body">
                    <table id="js-orders-table" class="table table-separate table-head-custom table-checkable nowrap">
                        <thead>
                            <tr class="small">
                                <th class="text-center" width="10%">#</th>
                                <th class="text-center" width="10%">Origin Invoice Code</th>
                                <th class="text-center" width="10%">Origin Order Code</th>
                                <th class="text-center" width="10%">Invoice Code</th>
                                <th class="text-center" width="10%">Order Code</th>
                                <th class="text-center" width="10%">Nama Pembeli</th>
                                <th class="text-center" width="10%">Nomor Resi</th>
                                <th class="text-center" width="10%">Ongkir</th>
                                <th class="text-center" width="10%">Subtotal</th>
                                <th class="text-center" width="10%">Total</th>
                                <th class="text-center" width="10%">Nomor HP</th>
                                <th class="text-center" width="10%">Alamat</th>
                                <th class="text-center" width="10%">Status</th>
                                <th class="text-center" width="10%">Status Pembayaran</th>
                                <th class="text-center" width="10%">Kurir</th>
                                <th class="text-center" width="10%">Tanggal Pemesanan</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    {{-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helpers/order-helper.js') }}"></script>

    <script>
        'use strict';

        $(document).ready(function() {
            const ajaxUrl = "{{ route('orders.index') }}";

            var ordersTable =  $('#js-orders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                autoWidth: true,
                select: true,
                language: {
                    infoFiltered: "",
                },
                lengthChange: false,
                pageLength: 20,
                order: [
                    [0, 'DESC']
                ],
                ajax: {
                    url: ajaxUrl,
                    type: 'GET',
                },
                scrollX: true,
                columns: [{
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            const index = meta.row + meta.settings._iDisplayStart + 1;
                            return index;
                        }
                    },
                    {
                        data: 'origin_invoice_code',
                        name: 'origin_invoice_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'origin_order_code',
                        name: 'origin_order_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'invoice_code',
                        name: 'invoice_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'order_code',
                        name: 'order_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'waybill_number',
                        name: 'waybill_number',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'shipping_cost',
                        name: 'shipping_cost',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'subtotal',
                        name: 'subtotal',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'total',
                        name: 'total',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'address',
                        name: 'address',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row,) {
                            return statusDescription(row.status);
                        }
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row,) {
                           return payementStatusDescription(row.payment_status);
                        }
                    },
                    {
                        data: 'courier',
                        name: 'courier',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'date_created',
                        name: 'date_created',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row, meta) {
                            let elements = '';


                            elements += `<div class="dropdown dropdown-inline">
                                <a href="javascript:void(0)"
                                    class="btn btn-sm btn-primary btn-icon"
                                    data-toggle="dropdown">
                                    <i class="la la-cog"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="nav nav-hoverable flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <span class="nav-text"><small>Detail</small></span>
                                            </a>
                                            <hr/ class="m-1">
                                            <a class="nav-link" href="#">
                                                <span class="nav-text"><small>Checkout to Baleomol.com</small> </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>`;

                            return elements;
                        },
                    }
                ]
            });

            function getDataFiltered() {
                let filterEl = $('.filter');
                let data = {};

                $.each(filterEl, function(i, v) {
                    let key = $(v).data('name');
                    let value = $(v).val();
                    if (key == 'date') {
                        if (value != '') {
                            value = value.split('/');
                            data[key] = JSON.stringify(value);
                        }
                    } else {
                        if (value != '') {
                            data[key] = value;
                        }
                    }
                });

                if (getURLVar('start')) {
                    data.start = getURLVar('start');
                }

                if (getURLVar('limit')) {
                    data.limit = getURLVar('limit');
                }

                reDrawTable(data);
            };

            function getFullUrl(data) {
                let
                    url = ajaxUrl,
                    params = '';

                $.each(data, function(key, value) {
                    if (!!value) {
                        params += `${key}=${value}&`;
                    }
                });

                params = params.replace(/\&$/, '');

                if (params != '') {
                    url = `${url}?${params}`;
                }
                return url;
            };

            function reDrawTable(data) {
                ordersTable.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }
        });
    </script>
@endpush
