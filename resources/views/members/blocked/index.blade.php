@extends('core.app')
@section('title', __('Member Blokir'))
@push('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Member Blokir</h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Member Blokir</h3>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                        <thead>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Email</th>
                                <th>Verifikasi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getMemberBlockeds as $key => $getMemberBlocked)
                            <tr class="text-center small">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $getMemberBlocked->username }}</td>
                                <td>{{ $getMemberBlocked->name }}</td>
                                <td> {{ $getMemberBlocked->phone }}</td>
                                <td>{{ $getMemberBlocked->email }}</td>
                                <td>
                                    @if ($getMemberBlocked->is_verified)
                                        <span class="label  label-light-success label-inline label-bold">Sudah</span>
                                    @else
                                        <span class="label  label-light-danger label-inline label-bold">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($getMemberBlocked->is_blocked)
                                        <span class="small">Blocked</span>
                                    @else
                                        <span class="small">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown dropdown-inline"><a href="javascript:void(0)"
                                            class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown"><i
                                                class="la la-cog"></i></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="nav nav-hoverable flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="javascript:void(0)"><span
                                                            class="nav-text">Detail</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/basic/paginations.js') }}"></script>
@endpush
