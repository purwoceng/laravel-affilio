@extends('core.app')
@section('title', __('Ubah Banner'))

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

        .select-type-info {
            font-size: 1rem;
            line-height: 1.5;
            color: #424242ba;
            background-color: #ebebeb;
            border-radius: .25rem;
            display: block;
            width: 100%;
            padding: .75rem 1rem;
            border: 1px solid #e9e9e9;
            box-shadow: 0px 1px 2px 0px rgb(40 40 40 / 30%);
            position: relative;
            overflow: hidden;
        }

        .select-type-info::after {
            content: '';
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            position: absolute;
        }

        .select2Wrapper {
            display: flex;
            width: 100%;
            flex-flow: column nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Banner</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Ubah Banner</h3>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @if (session()->has('info'))
                                <div class="alert alert-info" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong> {{ session()->get('info') }} </strong>
                                </div>
                            @endif

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

                            <form method="POST" action="{{ route('banners.update', $data->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Nama <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan nama banner"
                                            required name="name" value="{{ $data->name }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <select class="custom-select form-control js-type-selector" name="type" required>
                                            <option selected disabled>Pilih tipe banner</option>
                                            <option value="store" {{ $data->type == 'store' ? 'selected' : ''}}>Store</option>
                                            <option value="product" {{ $data->type == 'product' ? 'selected' : ''}}>Product</option>
                                            <option value="link" {{ $data->type == 'link' ? 'selected' : ''}}>Link</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Target <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <span class="select-type-info">Mohon pilih tipe terlebih dahulu!</span>
                                        <div class="js-input-url-wrapper d-none">
                                            <input type="text" class="js-input-url form-control" id="input-url" placeholder="Masukkan target url" value="{{ $data->type == 'link' ? $data->target_url : '' }}" />
                                        </div>
                                        <div class="js-product-selector-wrapper select2Wrapper d-none">
                                            <select id="input-product-id" class="js-product-selector not-triggered form-control">
                                                @if ($data->type == 'product')
                                                    <option selected value="{{ $data->target_url }}">{{ $productData['productName'] ?? '' }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="js-supplier-selector-wrapper select2Wrapper d-none">
                                            <select id="input-supplier-id" class="js-supplier-selector not-triggered form-control">
                                                @if ($data->type == 'store')
                                                    <option selected value="{{ $data->target_url }}">{{ $supplierData['store']['name'] ?? '' }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Posisi <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <select class="custom-select form-control" name="position" required>
                                            <option selected disabled>Silakan pilih posisi banner</option>
                                            <option value="home_top_section" {{ $data->position == 'home_top_section' ? 'selected' : ''}}>Home Top Section</option>
                                            <option value="home_bottom_section" {{ $data->position == 'home_bottom_section' ? 'selected' : ''}}>Home Bottom Section</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">File Foto<span class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="thumbnail_image" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <img src="{{ config('app.s3_url') . $data->image }}" class="img-fluid"
                                            width="150px">
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label class="col-2 col-form-label">Kategori Banner<span
                                            class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <select class="custom-select form-control" name="banner_category_id" required>
                                            <option disabled>Pilih kategori banner</option>
                                            @foreach ($bannerCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $data->banner_category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Deskripsi</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ $data->description }}" placeholder="Deskripsi banner" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Kembali</a>
                                    </div>

                                    <div class="p-1 ml-auto">
                                        <input type="hidden" name="target_url" value="{{ $data->target_url }}" />

                                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        'use strict';

        function productParamsHandler(params) {
            const query = { limit: 10 };
            if (params.term) query.keyword = params.term;

            return query;
        }

        function supplierParamsHandler(params) {
            const query = { limit: 10 };
            if (params.term) query.name = params.term;

            return query;
        }

        const API_URL = '{{ config('app.url') }}';
        const productsEndpoint = `${API_URL}/api/v1/products`;
        const suppliersEndpoint = `${API_URL}/api/v1/suppliers`;
        const SELECT2_AJAX_OPTIONS = {
            url: '',
            dataType: 'json',
            delay: 1000,
            data: null,
            processResults: null,
        };
        const SELECT2_OPTIONS = {
            placeholder: '',
            minimumInputLength: 3,
            ajax: { ...SELECT2_AJAX_OPTIONS },
            templateResult: null,
        };
        let rendered = 0;

        $(document).ready(function() {
            const urlText = $('.js-input-url');
            const productSelector = $('.js-product-selector');
            const supplierSelector = $('.js-supplier-selector');
            const urlTextWrapper = $('.js-input-url-wrapper');
            const productSelectorWrapper = $('.js-product-selector-wrapper');
            const supplierSelectorWrapper = $('.js-supplier-selector-wrapper');
            const selectTypeInfo = $('.select-type-info');
            const targetHiddenInput = $('input[name="target_url"]');

            function formatTemplateProduct(product) {
                if (product.loading) {
                    return product.productName;
                }

                const isVariant = Number(product.isVariation);
                const price = isVariant ? product.alternativePriceFormat : product.priceFormat;

                const productContainer = $(
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

                return productContainer;
            }

            function triggerSelectProduct() {
                productSelector.select2({
                    ...SELECT2_OPTIONS,
                    placeholder: 'Ketik Nama Produk',
                    templateResult: formatTemplateProduct,
                    ajax: {
                        ...SELECT2_AJAX_OPTIONS,
                        url: productsEndpoint,
                        data: productParamsHandler,
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
                });

                productSelector.on('select2:select', function (e) {
                    var data = e.params.data;
                    targetHiddenInput.val(data.id);
                });
            }

            function formatTemplateSupplier(supplier) {
                if (supplier.loading) {
                    return supplier.text;
                }

                const supplierContainer = $(
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

                return supplierContainer;
            }

            function triggerSelectSupplier() {
                supplierSelector.select2({
                    ...SELECT2_OPTIONS,
                    placeholder: 'Ketik Nama Supplier',
                    templateResult: formatTemplateSupplier,
                    ajax: {
                        ...SELECT2_AJAX_OPTIONS,
                        url: suppliersEndpoint,
                        data: supplierParamsHandler,
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
                });

                supplierSelector.on('select2:select', function (e) {
                    var data = e.params.data;
                    console.log({data});
                    targetHiddenInput.val(data.id);
                });
            }

            $('.js-type-selector').change(function(e) {
                const value = $(e.target).val();
                selectTypeInfo.addClass('d-none');
                urlTextWrapper.addClass('d-none');
                productSelectorWrapper.addClass('d-none');
                supplierSelectorWrapper.addClass('d-none');
                
                console.log({value1: value})
                
                if (rendered > 0) {
                    urlText.val('').trigger('change');
                    if (!supplierSelector.hasClass('not-triggered')) supplierSelector.val(null).trigger('change');
                    if (!productSelector.hasClass('not-triggered')) productSelector.val(null).trigger('change');
                    targetHiddenInput.val('');
                } else {
                    rendered += 1;
                }

                if (value === 'link') {
                    urlTextWrapper.removeClass('d-none');
                    return;
                } else if (value === 'store') {
                    if (supplierSelector.hasClass('not-triggered')) {
                        supplierSelector.removeClass('not-triggered');
                        triggerSelectSupplier();
                    }
                    
                    supplierSelectorWrapper.removeClass('d-none');
                    return;
                } else if (value === 'product') {
                    console.log({value})
                    if (productSelector.hasClass('not-triggered')) {
                        productSelector.removeClass('not-triggered');
                        triggerSelectProduct();
                    }

                    productSelectorWrapper.removeClass('d-none');
                    return;
                }

                selectTypeInfo.removeClass('d-none');
            });

            urlText.change(function(e) {
                const value = $(e.target).val();
                targetHiddenInput.val(value);
            });

            $('.js-type-selector').trigger('change');
        });
    </script>
@endpush
