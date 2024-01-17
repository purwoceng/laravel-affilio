@extends('core.app')

@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', __('Akses: Peran'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"></h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Peran</h3>
                    </div>
                    <a class="btn btn-success float-right" href="{{ route('roles.create') }}" title="Tambah User">
                        <i class="fas fa-plus mr-1 fa-sm"></i>
                        Tambah
                    </a>
                </div>

                <div class="card-body">
                    <table id="js-user-table" class="table table-bordered table-striped">
                        <thead>
                            <tr class="small">
                                <th width="7%">#</th>
                                <th>Nama Peran</th>
                                <th>Label Peran</th>
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
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}


    <script>
        'use strict';

        $(document).ready(function() {
            const ajaxUrl = "{{ route('roles.index') }}";

            $('#js-user-table').DataTable({
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
                        data: 'label',
                        name: 'label',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
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
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row, meta) {
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
                                            <a class="nav-link" href="${ajaxUrl}/detail/${data}">
                                                <span class="nav-text">Detail</span>
                                            </a>
                                            <a class="nav-link" onclick="return confirm('Anda yakin ingin menghapus data Peran ${row.name}')" href="${ajaxUrl}/delete/${data}">
                                                <span class="nav-text">Hapus</span>
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
