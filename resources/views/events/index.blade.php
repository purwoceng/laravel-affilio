@extends('core.app')
@section('title', __('Pengaturan Event'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Event</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Event</h3>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-1">
                            <a href="{{ route('event.create') }}" class="btn btn-sm btn-primary my-2"> <i
                                    class="fas fa-plus fa-sm  mr-1"></i>@lang('Buat')</a>
                        </div>
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

                    <table id="js-table-event" class="table table-separate table-head-custom table-checkable nowrap"
                        style="width:100%">


                        <thead>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Judul</th>
                                <th>Speaker</th>
                                <th>Harga</th>
                                <th>Tiket</th>
                                <th>Waktu</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Poster </th>
                                <th>Video</th>
                                <th>Tipe</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
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

@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>


    <script>
        $(document).ready(function() {
            const urlAjax = "{{ route('event.index') }}";

            var eventTable = $('#js-table-event').DataTable({
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
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'speaker',
                        name: 'speaker',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'price',
                        name: 'price',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'tiket',
                        name: 'tiket',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'time',
                        name: 'time',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'date',
                        name: 'date',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'location',
                        name: 'location',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'image',
                        name: 'image',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (data) return `<img src="${data}" class="image-fluid" width="80px">`;

                            return '-';
                        }
                    },
                    {
                        data: 'video',
                        name: 'video',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'type',
                        name: 'type',
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
                        data: 'status',
                        name: 'status',
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
                        data: 'id',
                        name: 'id',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            let showUrl = `{{ url('/event/show/${row.id}') }}`;
                            let editUrl = `{{ url('/event/edit/${row.id}') }}`;
                            let deleteUrl = `{{ url('/event/delete/${row.id}') }}`;
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
                                        <li class="nav-item">
                                            <a class="nav-link" href="${editUrl}"><span
                                                    class="nav-text">Ubah</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="${deleteUrl}"><span
                                                    class="nav-text">Hapus</span></a>
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
                eventTable.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }
        });
    </script>
@endpush
