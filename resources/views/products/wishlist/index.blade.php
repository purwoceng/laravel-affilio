@extends('core.app')
@section('title', __('Produk Wishlist'))

@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .product-cell {
            display: flex;
            padding: .25rem .5rem;
            gap: 1rem;
            flex-wrap: nowrap;
        }

        .product-cell .product-cell__image {
            height: 60px;
            width: 60px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border-radius: .25rem;
            border: 1px solid rgba(40, 40, 40, .36);
            overflow: hidden;
        }

        .product-cell .product-cell__image img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: 0 auto;
        }

        .product-cell .product-cell__content {
            display: flex;
            flex-flow: column nowrap;
            justify-content: space-between;
        }

        .product-cell .product-cell__title {
            font-weight: 500;
            font-size: 1.04rem;
            line-height: 1.5;
            color: #212121;
        }

        .product-cell .product-cell__stats {
            display: flex;
            flex-wrap: nowrap;
            gap: .75rem;
        }

        .product-cell .product-cell__stats .product-cell__stat {
            font-size: .75rem;
            line-height: 1.5;
            display: flex;
            gap: .35rem;
        }

        .product-cell .product-cell__stats .product-cell__stat i {
            font-size: .875rem;
            color: rgba(40, 40, 40, .56);
        }
    </style>
@endpush

@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Produk: Produk Wishlist</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Produk Wishlist</h3>
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
                    {{-- <div class="filter-wrapper">
                        <form action="#" class="form" id="filter">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 ml-auto">
                                    <div class="form-group">
                                        <label for="js-daterange-picker" class="font-weight-bold">Cari Produk</label>
                                        <select data-name="storeName"
                                                    id="input-supplier-id"
                                                    class="js-supplier-selector form-control filter" required></select>

                                                @error('supplier_id')
                                                    <small id="name-helper" class="form-text text-danger">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> --}}

                <div class="card-body">

                    <table id="js-table-product-wishlist" class="table table-separate table-head-custom table-checkable nowrap"
                        style="width:100%">

                        <thead>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Produk</th>
                                <th>Nama Member</th>
                                <th>Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>


    <script>
        $(document).ready(function() {
            const urlAjax = "{{ route('products.wishlists.index') }}";

            var wishlistTable = $('#js-table-product-wishlist').DataTable({
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
                pageLength: 50,
                order: [
                    [0, 'DESC']
                ],
                ajax: {
                    url: urlAjax,
                    type: 'GET',
                },
                scrollX: true,
                columns: [{
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'product_data',
                        name: 'product_data',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                       render: function(data) {
                            let element = '';
                            const isVariant = Number(data.isVariationActive);
                            const price = isVariant ? data.priceRangeVariation : data.priceFormat;

                            if (data.media?.[1]) {
                                element += `
                                    <div class="product-cell">
                                        <div class="product-cell__image">
                                            <img src="${data.media[1].link}" />
                                        </div>
                                        <div class="product-cell__content">
                                            <span class="product-cell__title">${data.name}</span>
                                            <div class="product-cell__stats">
                                                <div class="product-cell__stat"><i class="fas fa-store"></i> ${data.seller.storeName}</div>
                                                <div class="product-cell__stat"><i class="fas fa-money-bill"></i> Rp. ${price}</div>
                                                <div class="product-cell__stat"><i class="fas fa-box-open"></i> ${data.stock} Unit</div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else {
                                element += '-';
                            }

                            return element;
                        }
                    },
                    {
                        data: 'member_name',
                        name: 'member_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-right text-right small',
                        render: function(data, type, row, meta) {
                            let showUrl = `{{ url('/products/wishlist/show/${row.id}') }}`;
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

                ],
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
            reDrawTable(data);
        };

        function getFullUrl(data) {
            let
                url = urlAjax,
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
            wishlistTable.ajax.url(getFullUrl(data)).load(null, false);
        };

        });
    </script>
@endpush
