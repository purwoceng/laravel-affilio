@extends('core.app')
@section('title', __('Supplier Rekomendasi - Edit'))

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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Supplier Rekomendasi (Home Page)</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Edit Supplier Rekomendasi</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('supplier_home.update', $supplier->id) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="input-product-id">Supplier</label>
                            <select name="supplier_id"
                                id="input-product-id"
                                class="js-product-selector form-control"
                                required>
                                <option selected value="{{ $supplier->supplier_id }}">{{ $real_supplier['store']['name'] }}</option>
                            </select>

                            @error('supplier_id')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-queue-number">Urutan</label>
                            <select name="queue_number"
                                id="input-queue-number"
                                class="form-control"
                                aria-describedby="queue-helper"
                                required>
                                <option selected disabled value="0">Pilih nomor urut</option>

                                @foreach ($available_numbers as $number)
                                    <option value="{{ $number }}" 
                                        {{ $number == $supplier->queue_number ? 'selected' : '' }}>
                                        Ke-{{ $number}}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('queue_number')
                                <small id="queue-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        
                        <div class="form-group">
                            <label for="input-is-active">Status</label>
                            <select name="is_active"
                                id="input-is-active"
                                class="form-control"
                                aria-describedby="is-active-helper"
                                required>
                                <option value="1"
                                    {{ $supplier->is_active == '1' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" 
                                    {{ $supplier->is_active == '0' ? 'selected' : '' }}>
                                    Non-aktif
                                </option>
                            </select>
                            
                            @error('is_active')
                                <small id="is-active-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('supplier_home.index') }}">Kembali</a>
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
                                <div class="xselect-option__stat"><i class="far fa-map"></i> ${supplier.city} ${supplier.province}</div>
                            </div>
                        </div>
                    </div>`
                );

                return $container;
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
        });
    </script>
@endpush