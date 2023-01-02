@extends('core.app')
@section('title', __('Tambah Kategori Utama'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Utama</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Kategori</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="input-category-id">Kategori Produk Baleomol</label>
                            <select name="origin_category_id"
                                id="input-category-id"
                                class="form-control"
                                aria-describedby="category-helper"
                                required>
                                <option value="0" selected disabled>Pilih Kategori</option>

                                @if (!empty($categories))
                                    @foreach ($categories as $key => $category)
                                        <option
                                            value="{{ $category['no'] }}"
                                            {{ old('origin_category_id') == $category['no'] ? 'selected' : '' }}>
                                            {{ $category['name'] }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Gagal mendapatkan kategori - coba muat ulang</option>
                                @endif
                            </select>

                            @error('origin_category_id')
                                <small id="category-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-name">Nama</label>
                            <input name="name"
                                type="text"                                                                              
                                id="input-name"
                                class="form-control"
                                placeholder="Masukkan Nama Kategori"
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
                            <label for="input-description">Deskripsi</label>
                            <textarea
                                id="input-description"
                                class="form-control"
                                aria-describedby="image-helper"
                                name="description">{{ old('description') }}</textarea>
                            
                            @error('description')
                                <small id="image-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-image">Gambar</label>
                            <input type="file"
                                accept=".jpg, .jpeg, .png"
                                class="form-control"
                                aria-describedby="image-helper"
                                name="image"
                            />
                            
                            @error('image')
                                <small id="image-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('categories.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
