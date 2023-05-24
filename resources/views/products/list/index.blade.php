@extends('core.app')
@section('title', __('Daftar Produk Affilio'))
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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Daftar Produk Affilio</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Daftar Produk Affilio</h3>
                    </div>

                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong> {{ session()->get('success') }} </strong>
                        </div>
                    @endif

                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul>
                    @endif

                    <table id="js-table-product" class="table table-striped table-bordered table-sm" cellspacing="0"
                        width="100%">
                        <thead>
                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nama Produk</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="productName" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nama Toko</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="sellerName" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <tr class="text-center small">
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga Produk</th>
                                <th>Harga Jual Produk</th>
                                <th>Nama Toko</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
            const urlAjax = "{{ route('product_list.index') }}";

            var productTable = $('#js-table-product').DataTable({
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
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                        render: function(data, type, row) {
                            let element = '';

                            element += `
                                <div class="product-cell">
                                    <div class="product-cell__image">
                                        <img src="${row.image}" />
                                    </div>
                                    <div class="product-cell__content">
                                        <span class="product-cell__title">${row.name}</span>
                                        <div class="product-cell__stats"></div>
                                    </div>
                                </div>
                            `;

                            return element;
                        }
                    },
                    {
                        data: 'priceFormat',
                        name: 'priceFormat',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'sellPriceFormat',
                        name: 'sellPriceFormat',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'sellerUsername',
                        name: 'sellerUsername',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },

                ],
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
                productTable.ajax.url(getFullUrl(data)).load(null, true);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }
        });
    </script>
@endpush
