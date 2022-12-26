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

                    <div class="js-dashboard"></div>
                    <div class="d-flex">
                        <div class="ml-auto p-2">
                            <div class="form-group">
                                <label for="js-daterange-picker" class="font-weight-bold">Pilih tanggal</label>
                                <div class='input-group' id='js-daterange-picker'>
                                    <input type='text' class="form-control filter" readonly="readonly"
                                        data-name="date_range" placeholder="Select date range" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

            var ordersTable = $('#js-orders-table').DataTable({
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
                        render: function(data, type, row, ) {
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
                        render: function(data, type, row, ) {
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

            init();

            function init() {
                getDateRangeHandler();
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }

            function getDateRangeHandler() {
                $('#js-daterange-picker').daterangepicker({
                    timePickerSeconds: true,
                    showDropdwons: true,
                    autoApply: true,
                    ranges: {
                        'Semua': [moment(new Date('01-01-2021')), moment()],
                        'Hari Ini': [moment(), moment()],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    },
                    locale: {
                        format: 'YYYY-MM-DD',
                        separator: " to ",
                        applyLabel: "Apply",
                        cancelLabel: "Cancel",
                        fromLabel: "From",
                        toLabel: "To",
                        customRangeLabel: "Custom Range",
                        weekLabel: "W",
                        daysOfWeek: [
                            "Su",
                            "Mo",
                            "Tu",
                            "We",
                            "Th",
                            "Fr",
                            "Sa"
                        ],
                        monthNames: [
                            "Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "October",
                            "November",
                            "December"
                        ],
                        firstDay: 1
                    },
                    autoUpdateInput: false,
                    alwaysShowCalendars: false,
                    startDate: moment(),
                    endDate: moment(),
                }, rangePickerCB);
                rangePickerCB(moment(), moment());
                let data = [];
                data.push(moment().format('YYYY-MM-DD'));
                data.push(moment().format('YYYY-MM-DD'));
            }

            function rangePickerCB(start, end, label) {
                $('#js-daterange-picker').find('.form-control').val(start.format('YYYY-MM-DD') + '/' + end.format(
                    'YYYY-MM-DD'));
                // $('#js-date-range-omzet-all').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                // $('#js-date-range-omzet-disbursed').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                // $('#js-date-range-omzet-cancel').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                // $('#js-date-range-omzet-reject').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                // $('#js-date-range-omzet-success').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                // $('#js-date-range-order').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                getDataFiltered();

            };


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

                dashboardHandler(data);

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

            function dashboardHandler(data) {
                let dateRangeVal = data.date_range;
                let dataSplit = dateRangeVal.split("/");
                let startDate = dataSplit[0];
                let endDate = dataSplit[1];

                // let originOrderCode = data.origin_order_code;
                // let originInvoiceCode = data.origin_invoice_code;
                // let customerName = data.customer_name;
                // let waybillId = data.waybill_id;
                // let status = data.status;
                // let statusPayment = data.payment_status;
                // let handleBy = data.handle_by;
                let url = "{{ URL::to('/') }}" + `/orders/get-dashboard`;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        // origin_order_code: originOrderCode,
                        // origin_invoice_code: originInvoiceCode,
                        // customer_name: customerName,
                        // waybill_id: waybillId,
                        // status: status,
                        // payment_status: statusPayment,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {

                            mappingDashboard(response.data);
                        } else {
                            Swal.fire({
                                title: response.errors.title,
                                html: response.errors.messages,
                                icon: response.errors.icon,
                            })
                        }

                    },
                });
            }

            function mappingDashboard(data) {
                alert(JSON.stringify(data))
            }
        });
    </script>
@endpush
