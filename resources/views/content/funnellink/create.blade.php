@extends('core.app')
@section('title', __('Buat Kategori Funneling Home'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Funneling Home</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Buat Kategori Funneling Home</h3>
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

                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li> {{ $error }} </li>
                                    @endforeach
                                </ul>
                            @endif

                            <form method="POST" action="{{ route('funnel.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Tipe Panel Link <span class="text-danger">*</span></label>
                                    <select class="custom-select form-control js-type-selector" name="type" required>
                                        <option selected disabled>Pilih tipe funneling Home</option>
                                        <option value="header">Header</option>
                                        <option value="link">Link Training</option>
                                        <option value="video">Video Home</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Url Funneling<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Url Funneling"
                                        name="url" value=""/>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Funneling<span class="text-danger"></span></label>
                                    <textarea class="form-control" rows="7" placeholder="Masukkan Deskripsi Funneling"
                                        name="description" value="" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label>File Foto Thumbnail<span class="text-danger"></span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            name="image" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Countdown Timer Video<span class="text-danger"></span></label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Masukkan Countdown Timer Video"
                                        name="timer" value="" required />
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">detik</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('funnel.index') }}"
                                            class="btn btn-secondary">Kembali</a>
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
