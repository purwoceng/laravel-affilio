@extends('core.app')
@section('title', __('Event'))

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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Event</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Event</h3>
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

                            <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="input-event-name">Judul Event</label>
                                    <input type="text" id="input-event-name" class="form-control" name="name"
                                        value="{{ old('name') }}" aria-describedby="name-helper"
                                        placeholder="Masukkan Judul Event" required />

                                    @error('name')
                                        <small id="name-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-speaker">Speaker</label>
                                    <input type="text" id="input-event-speaker" class="form-control" name="speaker"
                                        value="{{ old('speaker') }}" aria-describedby="speaker-helper"
                                        placeholder="Masukkan Speaker" required />

                                    @error('speaker')
                                        <small id="speaker-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-price">Harga</label>
                                    <input type="text" id="input-event-price" class="form-control" name="price"
                                        value="{{ old('price') }}" aria-describedby="price-helper"
                                        placeholder="Masukkan Harga Tiket" required />

                                    @error('price')
                                        <small id="price-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-tiket">Tiket</label>
                                    <input type="text" id="input-event-tiket" class="form-control" name="tiket"
                                        value="{{ old('tiket') }}" aria-describedby="tiket-helper"
                                        placeholder="Masukkan Link TIket" required />

                                    @error('tiket')
                                        <small id="tiket-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-kuota">Kuota</label>
                                    <input type="text" id="input-event-kuota" class="form-control" name="kuota"
                                        value="{{ old('kuota') }}" aria-describedby="kuota-helper"
                                        placeholder="Masukkan Kuota Tiket" required />

                                    @error('kuota')
                                        <small id="kuota-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-time">Waktu</label>
                                    <input type="time" id="input-event-time" class="form-control" name="time"
                                        value="{{ old('time') }}" aria-describedby="time-helper"
                                        placeholder="Masukkan Waktu" required />

                                    @error('name')
                                        <small id="time-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-date">Tanggal</label>
                                    <input type="date" id="input-event-date" class="form-control" name="date"
                                        value="{{ old('date') }}" aria-describedby="date-helper"
                                        placeholder="Masukkan Tanggal" required />

                                    @error('date')
                                        <small id="date-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-location">Lokasi</label>
                                    <input type="text" id="input-event-location" class="form-control" name="location"
                                        value="{{ old('location') }}" aria-describedby="location-helper"
                                        placeholder="Masukkan Lokasi" required />

                                    @error('name')
                                        <small id="location-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="input-event-prefix">Prefix</label>
                                    <input type="text" id="input-event-prefix" class="form-control" name="prefix"
                                        value="{{ old('prefix') }}" aria-describedby="prefix-helper"
                                        placeholder="Masukkan Prefix" required />

                                    @error('name')
                                        <small id="prefix-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Poster<span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            name="image" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-event-video">Video</label>
                                    <input type="text" id="input-event-video" class="form-control" name="video"
                                        value="{{ old('video') }}" aria-describedby="video-helper"
                                        placeholder="Masukkan URL Video Event" required />

                                    @error('video')
                                        <small id="video-helper" class="form-text text-danger">
                                            {{ $validator_message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tipe <span class="text-danger">*</span></label>
                                    <select class="custom-select form-control js-type-selector" name="type" required>
                                        <option selected disabled>Pilih tipe event</option>
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        value="" placeholder="Masukkan deskripsi" />
                                </div>
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select class="custom-select form-control js-type-selector" name="status" required>
                                        <option selected disabled>Status Event</option>
                                        <option value="active">Active</option>
                                        <option value="non-active">Non-Active</option>
                                    </select>
                                </div>

                                <a class="btn btn-outline-danger" href="{{ route('event.index') }}">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endsection
