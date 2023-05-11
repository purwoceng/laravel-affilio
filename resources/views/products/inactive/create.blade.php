@extends('core.app')
@section('title', __('Produk Nonaktif'))

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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konfigurasi Produk Nonaktif</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Produk Nonaktif</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('products.inactive.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="input-product-id">Produk</label>
                            <select name="origin_product_id"
                                id="input-product-id"
                                class="js-product-selector form-control" required></select>

                            @error('origin_product_id')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <input type="hidden" name="origin_product_name" value="" />
                        <input type="hidden" name="origin_product_image_url" value="" />
                        <input type="hidden" name="origin_supplier_id" value="" />
                        <input type="hidden" name="origin_supplier_username" value="" />

                        <a class="btn btn-outline-danger" href="{{ route('products.inactive.index') }}">Kembali</a>
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

        const API_URL = '{{ config('app.url') }}';
        const productsEndpoint = `${API_URL}/api/v1/products`;

        $(document).ready(function() {
            function formatProduct(product) {
                if (product.loading) {
                    return product.productName;
                }

                const isVariant = Number(product.isVariation);
                const price = isVariant ? product.alternativePriceFormat : product.priceFormat;

                const $container = $(
                    `<div class="xselect-option clearfix">
                        <div class="xselect-option__avatar">
                            <img src="${product.image}" />
                        </div>
                        <div class="xselect-option__desc">
                            <div class="xselect-option__title">${product.text}</div>
                            <div class="xselect-option__stats">
                                <div class="xselect-option__stat"><i class="fas fa-store"></i> ${product.sellerName}</div>
                                <div class="xselect-option__stat"><i class="fas fa-money-bill"></i> Rp. ${price}</div>
                                <div class="xselect-option__stat"><i class="fas fa-box-open"></i> ${product.stock} Unit</div>
                            </div>
                        </div>
                    </div>`
                );

                return $container;
            }

            function formatProductSelection(product) {
                return product.productName;
            }

            $('.js-product-selector').select2({
                placeholder: 'Ketik Nama Produk',
                minimumInputLength: 3,
                ajax: {
                    url: productsEndpoint,
                    dataType: 'json',
                    delay: 1000,
                    data: function(params) {
                        const query = { limit: 10 };
                        if (params.term) query.keyword = params.term;

                        return query;
                    },
                    processResults: function(data, params) {
                        var result = { results: [] };

                        if (data.success) {
                            const { results: resultData } = data.data;
                            const products = resultData.map(item => {
                                return {
                                    id: item.productId,
                                    text: item.productName,
                                    image: item.picture,
                                    sellerId: item.sellerId,
                                    sellerName: item.sellerName,
                                    price: item.price,
                                    stock: item.stock,
                                    isVariation: item.isVariation,
                                    alternativePriceFormat: item.alternativePriceFormat,
                                    priceFormat: item.priceFormat,
                                }
                            });

                            result.results = products;
                        }

                        return result;
                    },

                },
                templateResult: formatProduct,
                // templateSelection: formatProductSelection,
            });

            $('.js-product-selector').on('select2:select', function (e) {
                var data = e.params.data;

                $('input[name="origin_product_name"]').val(data.text);
                $('input[name="origin_product_image_url"]').val(data.image);
                $('input[name="origin_supplier_id"]').val(data.sellerId);
                $('input[name="origin_supplier_username"]').val(data.sellerName);
            });
        });
    </script>
@endpush
