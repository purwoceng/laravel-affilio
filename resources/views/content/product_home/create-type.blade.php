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
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('product_home.store_type') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="input-name">Nama</label>
                            <input name="name"
                                type="text"                                                                              
                                id="input-name"
                                class="form-control"
                                placeholder="Masukkan Nama"
                                aria-describedby="name-helper" 
                                value="{{ old('name') }}"
                            />

                            @error('name')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-code">Kode</label>
                            <input name="code"
                                type="text"
                                id="input-code"
                                class="form-control"
                                placeholder="Masukkan Kode" 
                                aria-describedby="code-helper"
                                value="{{ old('code') }}"
                            />
                            
                            @error('code')
                                <small id="code-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('product_home.types') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection