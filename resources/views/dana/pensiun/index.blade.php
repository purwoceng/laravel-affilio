@extends('core.app')
@section('title', __('Dana Pensiun'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Kategori Dana Pensiun</h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Dana Pensiun</h3>
                    </div>
                </div>
                <div class="card-body">
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

                    <table id="js-pensiun-table" class="table table-striped table-bordered table-sm" cellspacing="0"
                        width="100%">
                        <thead>

                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            {{-- <label class="col-4 col-form-label">Username</label> --}}
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm filter"
                                                    data-name="code" placeholder="Type Code" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                {{-- <label class="col-4 col-form-label">Username</label> --}}
                                                <input type="text" class="form-control form-control-sm filter"
                                                    data-name="username" placeholder="Type Username" />

                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="form-group">
                                                {{-- <label class="col-4 col-form-label">Username</label> --}}
                                                <input type="text" class="form-control form-control-sm filter"
                                                    data-name="description" placeholder="Type Deskripsi" />

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-4 col-form-label">Pilih Bulan &
                                                    Tahun</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <div id="reportrange" class="pull-right"
                                                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%"
                                                        data-name="date_range">
                                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                        <span></span> <b class="caret"></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                            <tr class="small">
                                <th class="text-center">#</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Value</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Verifikasi</th>
                                <th class="text-center">Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>


    <script>
        $(document).ready(function() {
            const urlAjax = "{{ route('pensiun.index') }}";

            var pensiunTable = $('#js-pensiun-table').DataTable({
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
                        data: 'code',
                        name: 'code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'value',
                        name: 'value',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'title',
                        name: 'title',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'description',
                        name: 'description',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'status_verify',
                        name: 'status_verify',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'actions',
                        type: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            let showUrl =
                                `{{ url('pensiun/show/${row.id}') }}`;
                            let editUrl =
                                `{{ url('pensiun/edit/${row.id}') }}`;
                            let deleteUrl =
                                `{{ url('pensiun/delete/${row.id}') }}`;
                            let elements = '';
                            elements += `
                <div class="dropdown dropdown-inline"><a href="javascript:void(0)"
                        class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown"><i
                            class="la la-cog"></i></a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="nav nav-hoverable flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="${showUrl}"><span
                                        class="nav-text">Detail</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                `;

                            return elements;
                        }
                    }

                ],
            });



            $(function() {
                var start = moment().subtract(29, 'days');
                var end = moment();

                function cb(start, end) {
                    $('#reportrange span').html(start.format('MMMM , YYYY') + ' - ' + end.format(
                        'MMMM , YYYY'));
                }

                $('#reportrange').daterangepicker({
                    format: "mm-yyyy",
                    startView: "months",
                    minViewMode: "months",
                    startDate: start,
                    endDate: end,
                    ranges: {
                        'Semua': [moment(new Date('01-01-2021')), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],

                    }

                }, cb);

                cb(start, end);

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

            function reDrawTable(data) {
                pensiunTable.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }
        });
    </script>
@endpush
