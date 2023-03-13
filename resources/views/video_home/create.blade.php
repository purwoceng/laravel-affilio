@extends('core.app')
@section('title', __('Video Home Fitur Panel'))
@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Video Home Fitur Panel</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Tambah Video Home Fitur Panel</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('video_home.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="input-video-name">Header Video</label>
                            <input type="text"
                                id="input-video-name"
                                class="form-control"
                                name="header"
                                value="{{ old('name') }}"
                                aria-describedby="name-helper"
                                required
                            />

                            @error('name')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="input-video-url">Video</label>
                            <input type="file"
                                name="file"
                                id="input-video-url"
                                class="form-control"
                                value="{{ old('video') }}"
                                aria-describedby="url-helper"
                                required
                            />

                            @error('url')
                                <small id="url-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>


                        <a class="btn btn-outline-danger" href="{{ route('video_home.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
