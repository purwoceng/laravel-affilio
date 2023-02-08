@extends('core.app')
@section('title', __('Data Rekening Member'))
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Data Rekening Member</h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Rekening Member</h3>
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

                    <table id="js-table-member-account"
                        class="table table-separate table-head-custom table-hover table-striped table-checkable nowrap"
                        style="width:100%">
                        <thead>
                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Username</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="username" placeholder="Type Here">
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nama Bank</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="bank_name" placeholder="Type Here">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nomor Rekening</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="account_number" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Status Rekening</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select class="form-control form-control-sm filter" data-name="publish"
                                                        placeholder="Type Here">
                                                        <option disabled selected>Pilih Status Rekening</option>
                                                        <option value="all">Semua</option>
                                                        <option value="1">Sudah</option>
                                                        <option value="0">Belum</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Username</th>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Rekening</th>
                                <th>Verifikasi</th>
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
            const urlAjax = "{{ route('members.accounts.index') }}";

            var tableMemberAccount = $('#js-table-member-account').DataTable({
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
                        data: 'bank_name',
                        name: 'bank_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'account_number',
                        name: 'account_number',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'account_name',
                        name: 'account_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'publish',
                        name: 'publish',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.publish) {
                                return '<span class="label label-light-success label-inline label-bold">Sudah</span>';
                            } else {
                                return '<span class="label label-light-danger label-inline label-bold">Belum</span>';
                            }
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-center text-center small',
                        render: function(data, type, row, meta) {
                            let elements = '';

                            if (row.publish) {
                                elements += '<span class="text-center">-</span>';
                            } else {
                                elements += `
                                <div class="dropdown dropdown-inline">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown">
                                        <i class="la la-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <ul class="nav nav-hoverable flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link js-activation-account" href="javascript:void(0)" data-id="${row.id}">
                                                    <span class="nav-text" data-id="${row.id}">Verifikasi</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                `;
                            }

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
                tableMemberAccount.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }

            $(document).on('click', '.js-activation-account', function(e) {

                swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Anda akan melakukan verifikasi rekening ini!",
                    showCancelButton: true,
                    showConfirmButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Iya",
                    cancelButtonText: "Batal",
                }).then(function(result) {
                    if (result.value) {
                        Swal.fire({
                            showCloseButton: false,
                            showConfirmButton: false,
                            icon: 'info',
                            title: 'Harap Tunggu',
                            text: 'Sedang meneruskan pesanan Anda...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            onBeforeOpen: function() {
                                Swal.showLoading();
                            },
                        });
                        setTimeout(function() {
                            let urlActivation =
                                "{{ route('members.accounts.verification') }}";
                            let memberId = $(e.target).data('id');
                            $.ajax({
                                type: "POST",
                                url: urlActivation,
                                data: {
                                    id: memberId,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.icon,
                                        title: response.title,
                                        text: response.message,
                                    });

                                    getDataFiltered();
                                }
                            });

                        }, 500);
                    } else if (result.dismiss === 'Batal') {
                        console.log('Batal')
                    }

                });
            });
        });
    </script>
@endpush
