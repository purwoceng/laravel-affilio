@extends('core.app')
@section('title', __('Detail Nomor CS'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Nomor CS</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Nomor CS</h3>
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

                            <form method="POST" action="{{ route('cs-number.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nama <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan nama banner"
                                        name="name" value="{{ $data->name }}" disabled />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nomor Handphone <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan nomor handphone"
                                        name="number" value="{{ $data->number }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Tipe CS<span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Tipe Cs"
                                        name="category_type" value="{{ $data->category_type->name }}" disabled />
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('cs-number.index') }}" class="btn btn-secondary">Kembali</a>
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
