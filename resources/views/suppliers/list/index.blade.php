@extends('core.app')
@section('title', __('Daftar Supplier Affilio'))

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
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: auto !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
        }

        .xselect-option {
            display: flex;
            padding: .25rem .5rem;
            gap: 1rem;
            flex-wrap: nowrap;
        }

        .xselect-option .xselect-option__avatar {
            height: 60px;
            width: 60px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .xselect-option .xselect-option__avatar img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: 0 auto;
        }

        .xselect-option .xselect-option__desc {
            display: flex;
            flex-flow: column nowrap;
            justify-content: space-between;
        }

        .xselect-option .xselect-option__title {
            font-weight: 500;
            font-size: 1.04rem;
            line-height: 1.5;
            color: #212121;
        }

        .xselect-option .xselect-option__stats {
            display: flex;
            flex-wrap: nowrap;
            gap: .75rem;
        }

        .xselect-option .xselect-option__stats .xselect-option__stat {
            font-size: .75rem;
            line-height: 1.5;
            display: flex;
            gap: .35rem;
        }

        .xselect-option .xselect-option__stats .xselect-option__stat i {
            font-size: .875rem;
            color: rgba(40, 40, 40, .56);
        }

        .select2-container--default .select2-results>.select2-results__options {
            max-height: 400px;
        }
    </style>
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Daftar Supplier Affilio</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                @if (session('success'))
                    <div class="alert alert-success my-3 mx-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger my-3 mx-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Supplier Affilio</h3>
                    </div>
                </div>

                <div class="card-body">
                    <table id="js-supplier-nonactive-table" class="table table-separate table-head-custom table-checkable nowrap">
                        <thead>
                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="input-supplier-id">Cari Supplier</label>
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
                            </div>
                            <tr class="small">
                                <th>#</th>
                                <th>Supplier Name</th>
                                <th>Username</th>
                                <th>Store Name</th>
                                <th>Aksi</th>
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
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        'use strict';

        $(document).ready(function() {
            const ajaxUrl = "{{ route('supplierslist.index') }}";

            $('#js-supplier-nonactive-table').DataTable({
                destroy: true,
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
                        data: 'username',
                        name: 'username',
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
                        data: 'username',
                        name: 'username',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'storeName',
                        name: 'storeName',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'id',
                        type: 'id',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            let showUrl =
                                `{{ url('supplierslist/edit/${row.id}') }}`;
                            let editUrl =
                                `{{ url('members/member_type/edit/${row.id}') }}`;
                            let deleteUrl =
                                `{{ url('members/member_type/delete/${row.id}') }}`;
                            let elements = '';
                            elements += `
                            <div class="dropdown dropdown-inline"><a href="javascript:void(0)"
                                    class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown"><i
                                        class="la la-cog"></i></a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="nav nav-hoverable flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="${showUrl}"><span
                                                    class="nav-text">Add Supplier Non Aktif</span></a>
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
                supplierTable.ajax.url(getFullUrl(data)).load(null, true);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }

            const API_URL = '{{ config('app.baleomol_url') }}';
        const suppliersEndpoint = `${API_URL}/affiliator/sellers?appx=true`;

        $(document).ready(function() {
            function formatProduct(supplier) {
                if (supplier.loading) {
                    return supplier.text;
                }

                const $container = $(
                    `<div class="xselect-option clearfix">
                        <div class="xselect-option__avatar">
                            <img src="${supplier.image}" />
                        </div>
                        <div class="xselect-option__desc">
                            <div class="xselect-option__title">${supplier.text}</div>
                            <div class="xselect-option__stats">
                                <div class="xselect-option__stat"><i class="fas fa-map-marker-alt"></i> ${supplier.city} ${supplier.province}</div>
                            </div>
                        </div>
                    </div>`
                );

                return $container;
            }

            function formatProductSelection(supplier) {
                return supplier.productName;
            }

            $('.js-supplier-selector').select2({
                placeholder: 'Ketik Nama Toko Supplier',
                minimumInputLength: 3,
                ajax: {
                    url: suppliersEndpoint,
                    dataType: 'json',
                    data: function(params) {
                        const query = { limit: 10 };
                        if (params.term) query.name = params.term;

                        return query;
                    },
                    headers: {
                        Authorization: `Bearer {{ config('app.baleomol_token_auth') }}`,
                    },
                    processResults: function(response, params) {
                        var result = {
                            results: []
                        };

                        if (response.success) {
                            const productData = response.data.data
                            const suppliers = productData.map(item => {

                                return {
                                    id: item.id,
                                    text: item.store?.name || '',
                                    image: item.store?.image,
                                    city: item.store?.city,
                                    province: item.store?.province,
                                    username: item.username,
                                    image_url :item.store.logo|| '',
                                }
                            });

                            result.results = suppliers;
                        }

                        return result;
                    },

                },
                templateResult: formatProduct,
                // templateSelection: formatProductSelection,
            });

            $('.js-supplier-selector').on('select2:select', function (e) {
                var data = e.params.data;
                $('input[name="origin_supplier_store_name"]').val(data.text);
                $('input[name="origin_supplier_username"]').val(data.username);
                $('input[name="image_url"]').val(data.image_url);
            });
        });
        });
    </script>
@endpush
