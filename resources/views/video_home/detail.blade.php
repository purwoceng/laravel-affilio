@extends('core.app')
@section('title', __('Detail Kategori Video Home Default Panel'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Video Home Default Panel</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Video Home Fitur Panel</h3>
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

                            <form method="POST" action="{{ route('video_home.update', $data->id) }}"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Header Video <span class="text-danger">*</span></label>
                                    <input type="textarea" class="form-control" rows="9"
                                        name="header" value="{{ $data->header }}" disabled />
                                </div>
                              <div class="form-group">
                                    <label>Video <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-4">
                                    <video controls src="{{ config('app.s3_url') . $data->file }}"
                                        width="300px" height="250px">
                                </div>
                                <br>


                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('video_home.index') }}"
                                            class="btn btn-secondary">Kembali</a>
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
