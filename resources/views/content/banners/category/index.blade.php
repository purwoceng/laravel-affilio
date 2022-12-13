@extends('core.app')
@section('title', __('Pengaturan Kategori Banner'))
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
                        <h3 class="card-label">Kategori Banner</h3>
                    </div>

                </div>
                <div class="card-body">
                    <table id="js-table-member-blocked"
                        class="table table-separate table-head-custom table-checkable nowrap" style="width:100%">
                        <thead>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Nama </th>
                                <th>Kode</th>
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
