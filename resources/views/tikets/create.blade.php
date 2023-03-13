@extends('core.app')
@section('title', __('Tambah Tiket'))

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
    </style>
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Tiket</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Tiket</h3>
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

                            <form action="{{ route('tiket.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="input-tiket-name">Nama Tiket</label>
                                    <input type="text" id="input-tiket-name" class="form-control" name="name"
                                        value="{{ old('name') }}" aria-describedby="name-helper"
                                        placeholder="Masukkan Judul Tiket" required />

                                    @error('name')
                                        <small id="name-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-tiket-kuota">Kuota</label>
                                    <input type="text" id="input-tiket-kuota" class="form-control" name="kuota"
                                        value="{{ old('kuota') }}" aria-describedby="kuota-helper"
                                        placeholder="Masukkan kuota" required />

                                    @error('kuota')
                                        <small id="kuota-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-tiket-price">Harga</label>
                                    <input type="text" id="input-tiket-price" class="form-control" name="price"
                                        value="{{ old('price') }}" aria-describedby="price-helper"
                                        placeholder="Masukkan Harga" required />

                                    @error('price')
                                        <small id="price-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-tiket-start">Mulai</label>
                                    <input type="date" id="input-tiket-start" class="form-control" name="start"
                                        value="{{ old('start') }}" aria-describedby="start-helper"
                                        placeholder="Masukkan Tanggal" required />

                                    @error('start')
                                        <small id="start-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-tiket-finish">Berakhir</label>
                                    <input type="date" id="input-tiket-finish" class="form-control" name="finish"
                                        value="{{ old('finish') }}" aria-describedby="finish-helper"
                                        placeholder="Masukkan Tanggal" required />

                                    @error('name')
                                        <small id="finish-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>

                                <a class="btn btn-outline-danger" href="{{ route('tiket.index') }}">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endsection
