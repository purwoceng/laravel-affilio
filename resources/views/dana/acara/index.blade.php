@extends('core.app')
@section('title', __('Dana Bonus Acara'))
@push('css')
    {{-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dana Bonus Acara</h5>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-reward" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z" />
                            </svg>
                            Total Dana Bonus Acara
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-reward"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-reward-transaksi" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z" />
                            </svg>
                            Bonus Acara Transaksi
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-transaksi"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-reward-ongkir" class="card-title mb-5">0</h2>
                            <p class="card-subtitle mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box2-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4h-8.5ZM15 4.667V5H1v-.333L1.5 4h6V1h1v3h6l.5.667Z" />
                                </svg>
                                Bonus Acara Ongkir
                            </p>
                            <small class="card-text text-muted">( <span id="js-date-range-ongkir"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">List Dana Bonus Acara</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 ml-auto">
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


                    <div class="filter-wrapper">
                        <form action="#" class="form" id="filter">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <select class="form-control form-control-sm filter" data-name="code"
                                            placeholder="Type Here">
                                            <option disabled selected>Pilih Kode Bonus Acara</option>
                                            <option value="all">Semua</option>
                                            <option value="BRAT">BRAT(Bonus Acara Transaksi)</option>
                                            <option value="BRAO">BRAO(Bonus Acara Ongkir)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-sm btn-success  excel"
                                        data-toggle="modal">
                                        <i class="fas fa-file-excel fa-sm mr-1 excel"></i>@lang('Export Excel')
                                    </a>
                        </form>
                    </div>
                    <table id="js-eventfund-table"  class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                        <thead class="thead-secondary">
                            <tr class="small">
                                <th class="text-center">#</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Status Verifikasi</th>
                                <th class="text-center">Value</th>
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
    {{-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helpers/order-helper.js') }}"></script>
    <script>
        'use strict';


        $(document).ready(function() {
            const ajaxUrl = "{{ route('eventfund.index') }}";

            var ordersTable = $('#js-eventfund-table').DataTable({
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
                        data: 'username',
                        name: 'username',
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
                        data: 'title',
                        name: 'title',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'description',
                        name: 'description',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'status_verify',
                        name: 'status_verify',
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
                                `{{ url('eventfund/show/${row.id}') }}`;
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
                $('#js-date-range-reward').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-transaksi').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-ongkir').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
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

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        start_date: startDate,
                        end_date: endDate,

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

            let totalRewardAll = $('#js-dashboard-total-reward');
            let totalRewardTransaksi = $('#js-dashboard-reward-transaksi');
            let totalRewardOngkir = $('#js-dashboard-reward-ongkir');


            function mappingDashboard(data) {
                totalRewardAll.html(data.total_reward);
                totalRewardTransaksi.html(data.total_reward_transaksi);
                totalRewardOngkir.html(data.total_reward_ongkir);
            };


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
                        <label class="col-sm-2 col-form-label">Kode Bonus Acara</label>
                        <div class="col-sm-10">
                            <select class="form-control form-control-sm filter" data-name="status1" id="status1"
                                                placeholder="Type Here">
                                                <option disabled >Pilih Kode Bonus Acara</option>
                                                <option value="all" selected>Semua</option>
                                                <option value="BRAO">BRAO (Bonus Reward Acara Ongkir)</option>
                                                <option value="BRAT">BRAT (Bonus Reward Acara Transaksi)</option>
                                            </select>
                        </div>
                    </div>
                `;


                let elementFooter = `
                            <button type="submit" class="btn btn-light-success font-weight-bold" id="submitexcel">Export</button>
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button> </form>
                            `;

                excelModal.find(".modal-title").html('Input Export Excel Dana Bonus Acara');
                excelModal.find(".modal-body").html(elementHTML);
                excelModal.find(".modal-footer").html(elementFooter);
                excelModal.modal('show');

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

            // button export
            $(document).on('click', '#submitexcel', function() {
                var date_range1 = $("#date_range1").val();
                var status1 = $("#status1").val();
                var x = document.getElementById("submitexcel");
                x.disabled = true;
                var xhr = $.ajax({
                    type: 'GET',
                    url: "{{ route('eventfund.exportexcel') }}",
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
                        a.attr("download", 'Daftar Dana Bonus Acara-' + status1 + '-Tanggal-' +
                            date_range1 + '.xlsx');
                        a.attr("href", downloadURL);
                        $("body").append(a);
                        a[0].click();
                        $("body").remove(a);
                    }
                });
            });

        });
    </script>
@endpush
