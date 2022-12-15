@extends('core.app')
@section('title', __('Ubah Banner'))
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
                        <h3 class="card-label">Ubah Banner</h3>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @if (session()->has('info'))
                                <div class="alert alert-info" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong> {{ session()->get('info') }} </strong>
                                </div>
                            @endif

                            @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong> {{ session()->get('success') }} </strong>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('banners.update', $data->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Nama <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan nama banner"
                                            required name="name" value="{{ $data->name }}" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">File Foto<span class="text-danger">*</span></label>
                                    <div class="col-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="thumbnail_image" />
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <img src="{{ asset('storage/' . $data->image) }}" class="img-fluid" width="150px">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Tipe Banner<span
                                            class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <select class="custom-select form-control" name="banner_category_id" required>
                                            <option disabled>Pilih kategori banner</option>
                                            @foreach ($bannerCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $data->banner_category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Target Url<span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="target_url" name="target_url"
                                            value="{{ $data->target_url }}"" placeholder="Masukkan target url" required />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Deskripsi<span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ $data->description }}" placeholder="Masukkan target url" required />
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Kembali</a>
                                    </div>

                                    <div class="p-1 ml-auto">
                                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
