@extends('core.app')
@section('title', __('Detail Banner'))
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
                        <h3 class="card-label">Detail Banner</h3>
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

                            <form method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Nama <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan nama banner"
                                            name="name" value="{{ $data->name }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan tipe banner"
                                            name="type" value="{{ $data->type }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Posisi <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control"
                                            name="type" value="{{ $data->position }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">File Banner<span
                                            class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <img src="{{ config('app.s3_url') . $data->image }}" class="img-fluid"
                                            width="150px">
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label class="col-2 col-form-label">Kategori<span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <select class="custom-select form-control" name="banner_category_id">
                                            <option disabled>Pilih kategori banner</option>
                                            @foreach ($bannerCategories as $category)
                                                <option
                                                    value="{{ $category->id }} {{ $category->id == $data->banner_category_id ? 'selected' : '' }}">
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Target</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="target_url" name="target_url"
                                            value="{{ $data->target_url }}"" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Deskripsi</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ $data->description }}" placeholder="" disabled />
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Kembali</a>
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
