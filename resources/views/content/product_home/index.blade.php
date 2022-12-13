@extends('core.app')
@section('title', __('Produk Rekomendasi'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Produk Rekomendasi (Home Page)</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Produk Rekomendasi</h3>
                    </div>
                    <a class="btn btn-success float-right" href={{ route('product_home.create') }} title="Tambah Produk Rekomendasi">
                        <i class="fas fa-plus mr-1 fa-sm"></i>
                        Tambah
                    </a>
                </div>

                <div class="card-body">
                    <table id="js-user-table" class="table table-separate table-head-custom table-checkable nowrap">
                        <thead>
                            <tr class="small">
                                <th>#</th>
                                <th>Produk</th>
                                <th>Tipe</th>
                                <th>Nomor Urut</th>
                                <th>Status</th>
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