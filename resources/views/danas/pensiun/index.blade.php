@extends('core.app')
@section('title', __('Dana Pensiun'))

@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-sm-2 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dana : Pensiun</h5>
            </div>
        </div>
    </div>

    <div class="container text-center my-5">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dana_pensiun-1" class="card-title mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-puzzle" viewBox="0 0 16 16">
                                <path
                                    d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.459.459 0 0 0-.115.118.113.113 0 0 0-.012.025L6.5 4.5v.003l.003.01c.004.01.014.028.036.053a.86.86 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.86.86 0 0 0 .271-.194.213.213 0 0 0 .039-.063v-.009a.112.112 0 0 0-.012-.025.459.459 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.459.459 0 0 0 .115-.118.113.113 0 0 0 .012-.025L9.5 11.5v-.003a.214.214 0 0 0-.039-.064.859.859 0 0 0-.27-.193C8.91 11.1 8.49 11 8 11c-.491 0-.912.1-1.19.24a.859.859 0 0 0-.271.194.214.214 0 0 0-.039.063v.003l.001.006a.113.113 0 0 0 .012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238l-.244-2.855zM4.605 3a.5.5 0 0 0-.498.55l.001.007.29 3.4A.5.5 0 0 1 3.9 7.5h-.782c-.696 0-1.182-.497-1.469-.872a.459.459 0 0 0-.118-.115.112.112 0 0 0-.025-.012L1.5 6.5h-.003a.213.213 0 0 0-.064.039.86.86 0 0 0-.193.27C1.1 7.09 1 7.51 1 8c0 .491.1.912.24 1.19.07.14.14.225.194.271a.213.213 0 0 0 .063.039H1.5l.006-.001a.112.112 0 0 0 .025-.012.459.459 0 0 0 .118-.115c.287-.375.773-.872 1.469-.872H3.9a.5.5 0 0 1 .498.542l-.29 3.408a.5.5 0 0 0 .497.55h1.878c-.048-.166-.195-.352-.463-.557-.274-.21-.52-.528-.52-.943 0-.568.447-.947.862-1.154C6.807 10.123 7.387 10 8 10s1.193.123 1.638.346c.415.207.862.586.862 1.154 0 .415-.246.733-.52.943-.268.205-.415.39-.463.557h1.878a.5.5 0 0 0 .498-.55l-.001-.007-.29-3.4A.5.5 0 0 1 12.1 8.5h.782c.696 0 1.182.497 1.469.872.05.065.091.099.118.115.013.008.021.01.025.012a.02.02 0 0 0 .006.001h.003a.214.214 0 0 0 .064-.039.86.86 0 0 0 .193-.27c.14-.28.24-.7.24-1.191 0-.492-.1-.912-.24-1.19a.86.86 0 0 0-.194-.271.215.215 0 0 0-.063-.039H14.5l-.006.001a.113.113 0 0 0-.025.012.459.459 0 0 0-.118.115c-.287.375-.773.872-1.469.872H12.1a.5.5 0 0 1-.498-.543l.29-3.407a.5.5 0 0 0-.497-.55H9.517c.048.166.195.352.463.557.274.21.52.528.52.943 0 .568-.447.947-.862 1.154C9.193 5.877 8.613 6 8 6s-1.193-.123-1.638-.346C5.947 5.447 5.5 5.068 5.5 4.5c0-.415.246-.733.52-.943.268-.205.415-.39.463-.557H4.605z" />
                            </svg> 5.000.000
                        </h5>
                        <p class="card-subtitle">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                            </svg> --}}
                            Total Calon Dana Pensiun
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-ongkir-60"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-ongkir-30" class="card-title mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-puzzle-fill mr-1" viewBox="0 0 16 16">
                                <path
                                    d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.459.459 0 0 0-.115.118.113.113 0 0 0-.012.025L6.5 4.5v.003l.003.01c.004.01.014.028.036.053a.86.86 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.86.86 0 0 0 .271-.194.213.213 0 0 0 .036-.054l.003-.01v-.008a.112.112 0 0 0-.012-.025.459.459 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.459.459 0 0 0 .115-.118.113.113 0 0 0 .012-.025L9.5 11.5v-.003l-.003-.01a.214.214 0 0 0-.036-.053.859.859 0 0 0-.27-.194C8.91 11.1 8.49 11 8 11c-.491 0-.912.1-1.19.24a.859.859 0 0 0-.271.194.214.214 0 0 0-.036.054l-.003.01v.002l.001.006a.113.113 0 0 0 .012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238l-.244-2.855z" />
                            </svg>8.0000.000
                        </h5>
                        <p class="card-subtitle">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-ticket-detailed-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4 1a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5Zm0 5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5ZM4 8a1 1 0 0 0 1 1h6a1 1 0 1 0 0-2H5a1 1 0 0 0-1 1Z" />
                            </svg> --}}
                            Dana Pensiun
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-ongkir-30"></span> )</small>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-ongkir-10" class="card-title mb-5">0</h5>
                        <p class="card-subtitle">
                            What?
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-ongkir-10"></span> )</small>
                    </div>
                </div>
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
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                        <div class="card card-custom">
                            <div class="card-header flex-wrap py-8">
                                <div class="card-title">
                                    <h3 class="card-label">Dana Pensiun</h3>
                                </div>
                                <div class="filter-wrapper">
                                    <form action="#" class="form" id="filter">
                                        <div class="col-md-16">
                                            <div class="form-group form-group-sm row">
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="timestamp" class="form-control form-control-sm filter"
                                                        data-name="username" placeholder="Cari Tanggal">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="js-dana_pensiun-table"
                                    class="table table-separate table-head-custom table-checkable nowrap">
                                    <thead>
                                        <tr class="small">
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Dana</th>
                                            <th>Pencairan</th>
                                            <th>Dibuat</th>
                                            {{-- <th>Aksi</th> --}}
                                        </tr>
                                    </thead>
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
                        const ajaxUrl = "{{ route('pensiun.index') }}";

                        $('#js-dana_pensiun-table').DataTable({
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
                                },
                                {
                                    data: 'dana',
                                    name: 'dana',
                                    sortable: false,
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-left small',
                                },
                                {
                                    data: 'pencairan',
                                    name: 'pencairan',
                                    sortable: false,
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-left small',
                                },
                                {
                                    data: 'created_at',
                                    name: 'created_at',
                                    sortable: false,
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-left small',
                                },

                                // {
                                //     data: 'actions',
                                //     name: 'actions',
                                //     sortable: false,
                                //     orderable: false,
                                //     searchable: false,
                                //     className: 'text-center small',
                                //     render: function(data, type, row, meta) {
                                //         let showUrl =
                                //             `{{ url('dana_pensiun/show/${row.id}') }}`;
                                //         let editUrl =
                                //             `{{ url('dana_pensiun/edit/${row.id}') }}`;
                                //         let deleteUrl =
                                //             `{{ url('dana_pensiun/delete/${row.id}') }}`;
                                //         let elements = '';

                                //         elements += `<div class="dropdown dropdown-inline">
                //                 <a href="javascript:void(0)"
                //                     class="btn btn-sm btn-primary btn-icon"
                //                     data-toggle="dropdown">
                //                     <i class="la la-cog"></i>
                //                 </a>
                //                 <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                //                     <ul class="nav nav-hoverable flex-column">
                //                         <li class="nav-item">
                //                             <a class="nav-link" href="${showUrl}">
                //                                 <span class="nav-text">Detail</span>
                //                             </a>
                //                         </li>
                //                         <li class="nav-item">
                //                             <a class="nav-link" href="${editUrl}">
                //                                 <span class="nav-text">Edit</span>
                //                             </a>
                //                         </li>
                //                         <li class="nav-item">
                //                             <a class="nav-link"
                //                                 onclick="return confirm('Anda yakin ingin menghapus data ${row.header}')"
                //                                 href="${deleteUrl}">
                //                                 <span class="nav-text nav-text-danger">Hapus</span>
                //                             </a>
                //                         </li>
                //                     </ul>
                //                 </div>
                //             </div>`;

                                //         return elements;
                                //     },
                                // }
                            ]
                        });
                    });
                </script>
            @endpush
