@extends('core.app')
@section('title', __('Kategori Utama'))

@push('css')
    <link
        href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}"
        rel="stylesheet"
        type="text/css"
    />

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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Utama</h5>
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
                        <h3 class="card-label">Kategori</h3>
                    </div>
                    <a class="btn btn-success float-right" href={{ route('categories.create') }} title="Tambah Supplier Rekomendasi">
                        <i class="fas fa-plus mr-1 fa-sm"></i>
                        Tambah
                    </a>
                </div>

                <div class="card-body">
                    <table id="js-supplier-table" class="table table-separate table-head-custom table-checkable nowrap">
                        <thead>
                            <tr class="small">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Level</th>
                                <th>Gambar</th>
                                <th>Dibuat</th>
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

    <script>
        'use strict';

        const storageURL = "{{ asset('storage/') }}";

        $(document).ready(function() {
            const ajaxUrl = "{{ route('categories.index') }}";
            
            $('#js-supplier-table').DataTable({
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
                pageLength: 50,
                order: [
                    [0, 'DESC']
                ],
                ajax: {
                    url: ajaxUrl,
                    type: 'GET',
                },
                scrollX: true,
                columns: [
                    {
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            const index = meta.row + meta.settings._iDisplayStart + 1;

                            return index;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'origin_name',
                        name: 'origin_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'level',
                        name: 'level',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                        render: function (data, type, row, meta) {
                            switch (data) {
                                case 'main':
                                    return 'Utama';
                                case 'subkategori':
                                    return 'Subkategori';
                                case 'subkategori_1':
                                    return 'Subkategori Level 1';
                            }
                        },
                    },
                    {
                        data: 'image_url',
                        name: 'image_url',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                        render: function(data) {
                            let element = '';

                            if (data) {
                                element += `
                                    <div class="product-cell">
                                        <div class="product-cell__image">
                                            <img src="${data}" />
                                        </div>
                                    </div>
                                `;
                            } else {
                                element += `-`;
                            }

                            return element;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-right small',
                    },
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render : function(data, type, row, meta) {
                            let elements = '';

                            elements += `<div class="dropdown dropdown-inline">
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-primary btn-icon"
                                        data-toggle="dropdown">
                                        <i class="la la-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <ul class="nav nav-hoverable flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="${ajaxUrl}/edit/${row.id}">
                                                    <span class="nav-text">Edit</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ${row.name}')"
                                                    href="${ajaxUrl}/delete/${row.id}">
                                                    <span class="nav-text nav-text-danger">Hapus</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>`;

                            return elements;
                        },
                    }
                ]
            });
        });
    </script>
@endpush