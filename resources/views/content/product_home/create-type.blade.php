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
                        <h3 class="card-label">Tambah Tipe Produk Rekomendasi</h3>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('product_home.store_type') }}">
                        @csrf
                        <div class="form-group">
                            <label for="input-name">Nama</label>
                            <input name="name"
                                type="text"                                                                              
                                id="input-name"
                                class="form-control"
                                placeholder="Masukkan Nama" 
                            />
                        </div>
                        <div class="form-group">
                            <label for="input-code">Kode</label>
                            <input name="code"
                                type="text"
                                id="input-code"
                                class="form-control"
                                placeholder="Masukkan Kode" 
                            />
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('product_home.types') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection