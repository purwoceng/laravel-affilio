@extends('core.app')
@section('title', __('Ubah Tiket'))

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: auto !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
        }

        .xselect-option {
            display: flex;
            padding: .25rem .5rem;
            gap: 1rem;
            flex-wrap: nowrap;
        }

        .xselect-option .xselect-option__avatar {
            height: 60px;
            width: 60px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .xselect-option .xselect-option__avatar img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin: 0 auto;
        }

        .xselect-option .xselect-option__desc {
            display: flex;
            flex-flow: column nowrap;
            justify-content: space-between;
        }

        .xselect-option .xselect-option__title {
            font-weight: 500;
            font-size: 1.04rem;
            line-height: 1.5;
            color: #212121;
        }

        .xselect-option .xselect-option__stats {
            display: flex;
            flex-wrap: nowrap;
            gap: .75rem;
        }

        .xselect-option .xselect-option__stats .xselect-option__stat {
            font-size: .75rem;
            line-height: 1.5;
            display: flex;
            gap: .35rem;
        }

        .xselect-option .xselect-option__stats .xselect-option__stat i {
            font-size: .875rem;
            color: rgba(40, 40, 40, .56);
        }

        .select2-container--default .select2-results>.select2-results__options {
            max-height: 400px;
        }

        .select-type-info {
            font-size: 1rem;
            line-height: 1.5;
            color: #424242ba;
            background-color: #ebebeb;
            border-radius: .25rem;
            display: block;
            width: 100%;
            padding: .75rem 1rem;
            border: 1px solid #e9e9e9;
            box-shadow: 0px 1px 2px 0px rgb(40 40 40 / 30%);
            position: relative;
            overflow: hidden;
        }

        .select-type-info::after {
            content: '';
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            position: absolute;
        }

        .select2Wrapper {
            display: flex;
            width: 100%;
            flex-flow: column nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Event: Tiket</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Ubah Tiket</h3>
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

                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li> {{ $error }} </li>
                                    @endforeach
                                </ul>
                            @endif

                            <form method="POST" action="{{ route('tiket.update', $data->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Nama Tiket <span
                                            class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan nama tiket"
                                            required name="name" value="{{ $data->name }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Kuota <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan Kuota Tiket"
                                            required name="kuota" value="{{ $data->kuota }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Harga <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" placeholder="Masukkan Harga Tiket"
                                            required name="price" value="{{ $data->price }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Dimulai <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="date" class="form-control"
                                            placeholder="Masukkan Tanggal Tiket Dimulai" required name="start"
                                            value="{{ $data->start }}" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Berakhir <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="date" class="form-control"
                                            placeholder="Masukkan Tanggal Tiket Berakhir" required name="finish"
                                            value="{{ $data->finish }}" />
                                    </div>
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('tiket.index') }}" class="btn btn-secondary">Kembali</a>
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
