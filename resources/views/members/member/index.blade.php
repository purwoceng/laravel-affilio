@extends('core.app')
@section('title', __('Data Member'))
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Data Member</h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Member</h3>
                    </div>

                </div>
                <div class="card-body">
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

                    <table id="js-table-all-member" class="table table-separate table-head-custom table-checkable nowrap"
                        style="width:100%">
                        <thead>
                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nama</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="name" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Username</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="username" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Tipe Member</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select type="text" class="form-control form-control-sm filter"
                                                        data-name="member_type" placeholder="Type Here">
                                                        <option disabled>Pilih Tipe Member</option>
                                                        <option value="all" selected default>Semua</option>
                                                        @foreach ($member_type as $data)
                                                            <option value="{{ $data->id }}">{{ $data->type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Email</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="email" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">No Handphone</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="phone" placeholder="Type Here">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Email</th>
                                <th>Tipe Member</th>
                                <th>Verifikasi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            const urlAjax = "{{ route('members.index') }}";

            var tableAllMember = $('#js-table-all-member').DataTable({
                destroy: true,
                responsive: false,
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
                    url: urlAjax,
                    type: 'GET',
                },
                scrollX: true,
                columns: [{
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'username',
                        name: 'username',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'email',
                        name: 'email',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'member_type',
                        name: 'member_type',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'is_verified',
                        name: 'is_verified',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_verified) {
                                return '<span class="label  label-light-success label-inline label-bold">Sudah</span>';
                            } else {
                                return '<span class="label  label-light-danger label-inline label-bold">Belum</span>';
                            }
                        }
                    },
                    {
                        data: 'is_blocked',
                        name: 'is_blocked',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_blocked) {
                                return ' <span class="small">Blocked</span>';
                            } else {
                                return '<span class="small">Active</span>';
                            }
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            let elements = '';

                            elements += `
                                <div class="dropdown dropdown-inline">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown">
                                        <i class="la la-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <ul class="nav nav-hoverable flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="${urlAjax}/detail/${row.id}">
                                                    <span class="nav-text">Detail</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="${urlAjax}/edit/${row.id}">
                                                    <span class="nav-text">Edit Member</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>`;

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
                tableAllMember.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }
        });
    </script>
@endpush
