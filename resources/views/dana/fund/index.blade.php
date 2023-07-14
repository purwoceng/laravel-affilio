@extends('core.app')
@section('title', __('Riwayat Dana'))
@push('css')
    {{-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Riwayat Dana</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">List Riwayat Dana</h3>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-sm btn-success  excel" data-toggle="modal">
                        <i class="fas fa-download fa-sm mr-1 excel"></i>@lang('Export Excel')
                    </a>
                </div>

                <div class="card-body">

                    {{-- filter --}}
                    <div class="filter-wrapper">
                        <form action="#" class="form" id="filter">
                            <div class="col-lg-4 col-md-4 col-sm-12 ml-auto mb-2">
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
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Username</label>
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="username" placeholder="Find Username" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status</label>
                                        <select class="form-control form-control-sm filter" data-name="status"
                                            placeholder="Type Here">
                                            <option disabled selected>Pilih Status</option>
                                            <option value="">Semua</option>
                                            <option value="debit">Debit</option>
                                            <option value="credit">Kredit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Kode</label>
                                        <select class="form-control form-control-sm filter" data-name="code"
                                            placeholder="Type Here">
                                            <option value="">Semua</option>
                                            <option value="PDK">PDK (Penarikan Komisi)</option>
                                            <option value="PDB">PDB (Penarikan Bonus)</option>
                                            <option value="BRAO">BRAO (Bonus Reward Acara Ongkir)</option>
                                            <option value="BRAT">BRAT (Bonus Reward Acara Transaksi)</option>
                                            <option value="BPC5">BPC5 (Bonus Pensiun Challenge 5)</option>
                                            <option value="BPC4">BPC4 (Bonus Pensiun Challenge 4)</option>
                                            <option value="BPC3">BPC3 (Bonus Pensiun Challenge 3)</option>
                                            <option value="BPC2">BPC2 (Bonus Pensiun Challenge 2)</option>
                                            <option value="BFO">BFO (Bonus Founder)</option>
                                            <option value="BSC51">BSC51 (Bonus Super Challenge 5 1)</option>
                                            <option value="BSC52">BSC52 (Bonus Super Challenge 5 2)</option>
                                            <option value="BSC41">BSC41 (Bonus Super Challenge 4 1)</option>
                                            <option value="BSC42">BSC42 (Bonus Super Challenge 4 2)</option>
                                            <option value="BSC31">BSC31 (Bonus Super Challenge 3 1)</option>
                                            <option value="BSC32">BSC32 (Bonus Super Challenge 3 2)</option>
                                            <option value="BSC21">BSC21 (Bonus Super Challenge 2 1)</option>
                                            <option value="BSC22">BSC22 (Bonus Super Challenge 2 2)</option>
                                            <option value="BC5">BC5 (Bonus Peringkat Challenge 5)</option>
                                            <option value="BC4">BC4 (Bonus Peringkat Challenge 4)</option>
                                            <option value="BC3">BC3 (Bonus Peringkat Challenge 3)</option>
                                            <option value="BC2">BC2 (Bonus Peringkat Challenge 2)</option>
                                            <option value="BC1">BC1 (Bonus Peringkat Challenge 1)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Kode Order</label>
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="order_code" placeholder="Find Kode Order" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status Transfer</label>
                                        <select class="form-control form-control-sm filter" data-name="status_transfer"
                                            placeholder="Type Here">
                                            <option disabled selected>Pilih Status</option>
                                            <option value="">Semua</option>
                                            <option value="success">Sukses</option>
                                            <option value="">Belum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status Bonus Dana</label>
                                        <select class="form-control form-control-sm filter" data-name="is_active"
                                            placeholder="Type Here">
                                            <option disabled selected>Pilih Status</option>
                                            <option value="">Semua</option>
                                            <option value="0">Calon Bonus</option>
                                            <option value="1">Bonus</option>
                                            <option value="2">Gagal Bonus</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <table id="js-fund-table" class="table table-striped table-bordered table-sm" cellspacing="0"
                        width="100%">
                        <thead class="thead-secondary">
                            <tr class="small">
                                <th class="text-center">#</th>
                                <th class="text-center">Kode Order</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Status Dana</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Value</th>
                                <th class="text-center">Status Transfer</th>
                                <th class="text-center">Status Verifikasi</th>
                                <th class="text-center">Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('orders.partials.modal')
@endsection


@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helpers/order-helper.js') }}"></script>
    <script>
        'use strict';


        $(document).ready(function() {
            const ajaxUrl = "{{ route('fund.index') }}";

            var ordersTable = $('#js-fund-table').DataTable({
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                autoWidth: true,
                select: true,
                language: {
                    infoFiltered: "",
                },
                pageLength: 50,
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
                        data: 'order_code',
                        name: 'order_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'username',
                        name: 'username',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'email',
                        name: 'email',
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
                    },
                    {
                        data: 'code',
                        name: 'code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row) {
                            return statusDescription(row.code);
                        }
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_active == '1') {
                                return '<span class="label  label-light-success label-inline label-bold">Bonus</span>';
                            } else if (row.is_active == '0') {
                                return '<span class="label  label-light-danger label-inline label-bold">Calon Bonus</span>';
                            } else {
                                return '<span class="label  label-light-danger label-inline label-bold">Gagal Bonus</span>';
                            }
                        }
                    },
                    {
                        data: 'title',
                        name: 'title',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'value',
                        name: 'value',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'status_transfer',
                        name: 'status_transfer',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row) {
                            return statusDescription(row.status_transfer);
                        }
                    },
                    {
                        data: 'status_verify',
                        name: 'status_verify',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row) {
                            return statusDescription(row.status_verify);
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'actions',
                        type: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            let showUrl =
                                `{{ url('fund/show/${row.id}') }}`;
                            let editUrl =
                                `{{ url('fund/edit/${row.id}') }}`;
                            let deleteUrl =
                                `{{ url('fund/delete/${row.id}') }}`;
                            let elements = '';
                            elements += `
                            <div class="dropdown dropdown-inline"><a href="javascript:void(0)"
                                    class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown"><i
                                        class="la la-cog"></i></a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="nav nav-hoverable flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="${showUrl}"><span
                                                    class="nav-text">Detail</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            `;

                            return elements;
                        }
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
                $('#js-date-range-omzet').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-supplier-price').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-bonus-profit').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-profit-keuntungan').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-ongkir-60').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-ongkir-30').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-ongkir-10').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-unique-code').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-service-fee').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-total-order').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
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
                let url = "{{ URL::to('/') }}" + `/eventfund/get-dashboard`;

                // $.ajax({
                //     type: "GET",


                //     url: url,
                //     data: {
                //         start_date: startDate,
                //         end_date: endDate,

                //     },
                //     dataType: "json",
                //     success: function(response) {
                //         if (response.status) {

                //             mappingDashboard(response.data);
                //         } else {
                //             Swal.fire({
                //                 title: response.errors.title,
                //                 html: response.errors.messages,
                //                 icon: response.errors.icon,
                //             })
                //         }

                //     },
                // });
            }

            //exportexcel
            let excelModal = $('#js-detail-modal');
            $(document).on("click", ".excel", function(e) {
                let elementHTML = `
                    <div class="form-group row">
                        <label for="js-daterange-picker1" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <div class='input-group' id='js-daterange-picker'>
                                    <input type='text' class="form-control filter"
                                            id="date_range1" name="date_range1" placeholder="Select date range" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                </div>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kode Penarikan Dana</label>
                        <div class="col-sm-10">
                            <select class="form-control form-control-sm filter" data-name="status1" id="status1"
                                                placeholder="Type Here">
                                                <option disabled selected>Pilih Kode Dana</option>
                                            <option value="all">Semua</option>
                                            <option value="PDK">PDK (Penarikan Komisi)</option>
                                            <option value="PDB">PDB (Penarikan Bonus)</option>
                                            <option value="BRAO">BRAO (Bonus Reward Acara Ongkir)</option>
                                            <option value="BRAT">BRAT (Bonus Reward Acara Transaksi)</option>
                                            <option value="BPC5">BPC5 (Bonus Pensiun Challenge 5)</option>
                                            <option value="BPC4">BPC4 (Bonus Pensiun Challenge 4)</option>
                                            <option value="BPC3">BPC3 (Bonus Pensiun Challenge 3)</option>
                                            <option value="BPC2">BPC2 (Bonus Pensiun Challenge 2)</option>
                                            <option value="BFO">BFO (Bonus Founder)</option>
                                            <option value="BSC51">BSC51 (Bonus Super Challenge 5 1)</option>
                                            <option value="BSC52">BSC52 (Bonus Super Challenge 5 2)</option>
                                            <option value="BSC41">BSC41 (Bonus Super Challenge 4 1)</option>
                                            <option value="BSC42">BSC42 (Bonus Super Challenge 4 2)</option>
                                            <option value="BSC31">BSC31 (Bonus Super Challenge 3 1)</option>
                                            <option value="BSC32">BSC32 (Bonus Super Challenge 3 2)</option>
                                            <option value="BSC21">BSC21 (Bonus Super Challenge 2 1)</option>
                                            <option value="BSC22">BSC22 (Bonus Super Challenge 2 2)</option>
                                            <option value="BC5">BC5 (Bonus Peringkat Challenge 5)</option>
                                            <option value="BC4">BC4 (Bonus Peringkat Challenge 4)</option>
                                            <option value="BC3">BC3 (Bonus Peringkat Challenge 3)</option>
                                            <option value="BC2">BC2 (Bonus Peringkat Challenge 2)</option>
                                            <option value="BC1">BC1 (Bonus Peringkat Challenge 1)</option>
                                            </select>
                        </div>
                    </div>
                `;


                let elementFooter = `
                            <button type="submit" class="btn btn-light-success font-weight-bold" id="submitexcel">Export</button>
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button> </form>
                            `;

                excelModal.find(".modal-title").html('Input Export Excel Riwayat Dana');
                excelModal.find(".modal-body").html(elementHTML);
                excelModal.find(".modal-footer").html(elementFooter);
                excelModal.modal('show');

            });

            //button export
            $(document).on('click', '#submitexcel', function() {
                var date_range1 = $("#date_range1").val();
                var status1 = $("#status1").val();
                var x = document.getElementById("submitexcel");
                x.disabled = true;
                var xhr = $.ajax({
                    type: 'GET',
                    url: "{{ route('fund.exportexcel') }}",
                    data: {
                        "daterange1": date_range1,
                        "status1": status1
                    },
                    cache: false,
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 2) {
                                if (xhr.status == 200) {
                                    xhr.responseType = "blob";
                                } else {
                                    xhr.responseType = "text";
                                }
                            }
                        };
                        return xhr;
                    },
                    success: function(data) {
                        const url = window.URL || window.webkitURL;
                        const downloadURL = url.createObjectURL(data);
                        var a = $("<a />");
                        a.attr("download", 'Daftar Riwayat Dana-' + status1 + '-Tanggal-' +
                            date_range1 + '.xlsx');
                        a.attr("href", downloadURL);
                        $("body").append(a);
                        a[0].click();
                        $("body").remove(a);
                    }
                });
            });

            //js datepicker excel
            $('#js-detail-modal').on('shown.bs.modal', function(e) {
                $('input[name="date_range1"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
                        ' to ' + end.format('YYYY-MM-DD'));
                });
            });

        });
    </script>
@endpush
