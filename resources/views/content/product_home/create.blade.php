@extends('core.app')
@section('title', __('Produk Rekomendasi'))

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: auto !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
        }
    </style>
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Produk Rekomendasi (Home Page)</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Produk Rekomendasi</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('product_home.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="input-product-id">Produk</label>
                            <select name="product_id"
                                id="input-product-id"
                                class="js-product-selector form-control"></select>

                            @error('product_id')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-queue-number">Urutan</label>
                            <input name="queue_number"
                                type="number"
                                min="0"
                                max="100"
                                id="input-queue-number"
                                class="form-control"
                                placeholder="Masukkan Nomor Urut Produk" 
                                aria-describedby="queue-helper"
                            />
                            
                            @error('queue_number')
                                <small id="queue-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('product_home.index') }}">Kembali</a>
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
        const productsEndpoint = `${API_URL}/products`;

        $(document).ready(function() {
            function formatProduct(product) {
                if (product.loading) {
                    return product.productName;
                }

                const container = $(
                    `<div class="select2-result-repository clearfix">
                        <div class="select2-result-repository__avatar">
                            <img src="${product.picture}" />
                        </div>
                        <div class="select2-result-repository__meta">
                            <div class="select2-result-repository__title">${product.productName}</div>
                            <div class="select2-result-repository__statistics">
                                <div class="select2-result-repository__forks"><i class="far fa-flash"></i> ${product.sellerName}</div>
                                <div class="select2-result-repository__stargazers"><i class="far fa-star"></i> ${product.sellPriceFormat}</div>
                                <div class="select2-result-repository__watchers"><i class="far fa-eye"></i> ${product.stock}</div>
                            </div>
                        </div>
                    </div>`
                );

                return container;
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
                    data: function(params) {
                        const query = { limit: 10 };
                        if (params.term) query.keyword = params.term;

                        return query;
                    },
                    headers: {
                        Authorization: `Bearer {{ config('app.baleomol_key') }}`,
                    },
                    processResults: function(data, params) {
                        let result = { results: [] };

                        if (data.success) {
                            const { results: resultData } = data.data;
                            const products = resultData.map(item => {
                                return {
                                    id: item.productId,
                                    text: item.productName,
                                }
                            });

                            result.results = products;
                        }

                        return result;
                    },
                },
                // templateResult: formatProduct,
                // templateSelection: formatProductSelection,
            });
        });
    </script>
@endpush