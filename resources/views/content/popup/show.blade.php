@extends('core.app')
@section('title', __('Detail Popup Notification'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Funnel</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Popup Notification</h3>
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

                            <form method="POST" action="{{ route('popup.update', $data->id) }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('put') }}

                                <div class="form-group">
                                    <label>Title Popup<span class="text-danger"></span></label>
                                    <input class="form-control" placeholder="Masukkan Url Funnel Link" name="title"
                                        value="{{ $data->title }}" required disabled></input>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">File Poster<span
                                            class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <img src="{{ config('app.s3_url') . $data->image }}" class="img-fluid"
                                            width="150px">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>URL Popup<span class="text-danger"></span></label>
                                    <input class="form-control" placeholder="Masukkan Deskripsi Funnel Link" name="url"
                                        value="{{ $data->url }}" required disabled></input>
                                </div>
                                <div class="form-group">
                                    <label>Popup Dibuat<span class="text-danger"></span></label>
                                    <input class="form-control" placeholder="Masukkan Deskripsi Funnel Link" name="created_at"
                                        value="{{ $data->created_at }}" required disabled></input>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('popup.index') }}" class="btn btn-danger">Kembali</a>
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
