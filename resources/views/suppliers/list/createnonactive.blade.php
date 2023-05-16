@extends('core.app')
@section('title', __('Supplier Non Active - Tambah'))

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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Tambah Supplier Non Active</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Supplier Non Active</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('suppliers.nonactive.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Nama Suppliers<span class="text-danger">*</span></label>
                            <input class="form-control" placeholder="Masukkan Nama Suppliers .." name="title" value="{{$results['username']}}" required></input>
                        </div>

                        <input type="hidden" name="origin_supplier_store_name" value="" />
                        <input type="hidden" name="origin_supplier_username" value="" />
                        <input type="hidden" name="image_url" value="" />
                        <a class="btn btn-outline-danger" href="{{ route('suppliers.nonactive.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        'use strict';

        const API_URL = '{{ config('app.baleomol_url') }}';
        const suppliersEndpoint = `${API_URL}/suppliers`;

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
                        Authorization: `Bearer {{ config('app.baleomol_key') }}`,
                    },
                    processResults: function(data, params) {
                        var result = { results: [] };
                        if (data.success) {
                            const { results: resultData } = data.data;

                            const suppliers = resultData.map(item => {

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
    </script>
@endpush
