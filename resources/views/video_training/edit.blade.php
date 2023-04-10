@extends('core.app')
@section('title', __('Edit Video Training'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Video Training</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Edit Video Training</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif


                    <form action="{{ route('video_training.update', $video->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="input-member-type-id">Tipe Member</label>
                            <select name="member_type_id"
                                id="input-member-type-id"
                                class="form-control"
                                aria-describedby="member-type-helper"
                                required>
                                <option selected disabled value="0">Pilih Tipe Member</option>

                                @foreach ($member_types as $key => $member_type)
                                    <option
                                        value="{{ $member_type->id }}"
                                        {{ $video->member_type_id == $member_type->id ? 'selected' : '' }}>
                                        {{ $member_type->type }}
                                    </option>
                                @endforeach
                            </select>

                            @error('member_type_id')
                                <small id="member-type-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="input-video-name">Judul Video</label>
                            <input type="text"
                                id="input-video-name"
                                class="form-control"
                                name="title"
                                value="{{ $video->title }}"
                                aria-describedby="name-helper"
                                required
                            />

                            @error('title')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-video-name">Url Video</label>
                            <input type="text"
                                id="input-video-name"
                                class="form-control"
                                name="url"
                                value="{{ $video->url }}"
                                aria-describedby="name-helper"
                                required
                            />

                            @error('url')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <a class="btn btn-outline-danger" href="{{ route('video_training.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
