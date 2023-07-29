@extends('core.app')
@section('title', __('Buat Push Notification'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Push Notification</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Buat Push Notification</h3>
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

                            <form method="POST" action="{{ route('pushnotification.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Title Notification<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Title Notification"
                                        name="title" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Push Notification<span class="text-danger"></span></label>
                                    <textarea class="form-control" rows="4" placeholder="Masukkan Deskripsi Push Notification" name="description"
                                        value=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label>URL Push Notification<span class="text-danger"></span></label>
                                    <input class="form-control" rows="4" placeholder="Masukkan url Push Notification" name="url"
                                        value=""/>
                                </div>
                               
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('pushnotification.index') }}" class="btn btn-danger">Kembali</a>
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
