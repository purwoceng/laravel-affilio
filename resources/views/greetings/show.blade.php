@extends('core.app')
@section('title', __('Detail Greeting Event'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Detail Greeting Event</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Greeting Event</h3>
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

                            <form method="POST" action="{{ route('greeting.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Judul <span class="text-danger"></span></label>
                                    <div class="form-group">
                                        <input type="textarea" class="form-control" rows="9" name="title"
                                            value="{{ $data->title }}" disabled />
                                    </div>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-3 col-form-label">Thumbnail</label>
                                    <div class="col-10">
                                        <img src="{{ config('app.s3_url') . $data->thumbnail }}" class="img-fluid"
                                            width="150px">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Countdown Timer Video<span class="text-danger"></span></label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control"
                                            placeholder="Masukkan Countdown Timer Video" name="timer"
                                            value="{{ $data->timer }}" required disabled />
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">detik</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-3 col-form-label">URL</label>
                                    <div class="form-group">
                                        <input class="form-control" rows="7" name=""
                                            value="{{ $data->url }}" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-is-active">Status</label>
                                    <select name="creator_id" id="input-is-active" class="form-control"
                                        aria-describedby="is-active-helper" required disabled>
                                        <option value="0" {{ $data->is_active == '0' ? 'selected' : '' }}>
                                            Non-Active
                                        </option>
                                        <option value="1" {{ $data->is_active == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                    </select>

                                    @error('is_active')
                                        <small id="is-active-helper" class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('greeting.index') }}" class="btn btn-secondary">Kembali</a>
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
