@extends('core.app')
@section('title', __('Halaman Cover Supplier'))

@push('css')
    <link
        href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}"
        rel="stylesheet"
        type="text/css"
    />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Cover Supplier</h5>
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
                        <h3 class="card-label">Halaman Cover Supplier</h3>
                    </div>
                    <a class="btn btn-success float-right" href="{{ route('supplierscover.create') }}" title="Tambah cover Supplier">
                        <i class="fas fa-plus mr-1 fa-sm"></i>
                        Tambah
                    </a>
                </div>

                <div class="card-body">
                    <table id="js-cover-table"  class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                            <tr class="small">
                                <th>#</th>
                                <th>Gambar Cover Supplier</th>
                                <th>Status</th>
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

        $(document).ready(function() {
            const ajaxUrl = "{{ route('supplierscover.index') }}";

            $('#js-cover-table').DataTable({
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
                        data: 'image',
                        name: 'image',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (data)  return `<img src="${data}" class="image-fluid" width="80px">`;
                            return '-';
                        }
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data) {
                            let element = '';

                            if (Number(data)) {
                                element +=
                                    `<span class="label label-light-success label-inline label-bold">Aktif</span>`;
                            } else {
                                element +=
                                    `<span class="label label-light-danger label-inline label-bold">Non-Aktif</span>`;
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
                        className: 'text-left small',
                    },

                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render : function(data, type, row, meta) {
                            let showUrl =
                                `{{ url('supplierscover/show/${row.id}') }}`;
                            let editUrl =
                                `{{ url('supplierscover/edit/${row.id}') }}`;
                            let deleteUrl =
                                `{{ url('supplierscover/delete/${row.id}') }}`;
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
                                                <a class="nav-link" href="${showUrl}">
                                                    <span class="nav-text">Detail</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="${editUrl}">
                                                    <span class="nav-text">Edit</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ${row.image}')"
                                                    href="${deleteUrl}">
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
