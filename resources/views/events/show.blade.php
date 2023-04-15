@extends('core.app')
@section('title', __('Detail Event'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Event</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Event</h3>
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

                            <form method="POST" action="{{ route('event.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="name" value="{{ $data->name }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Speaker</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="speaker" value="{{ $data->speaker }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="price" value="{{ $data->price }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Tiket</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="tiket" value="{{ $data->tiket }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Kuota</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="kuota" value="{{ $data->kuota }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Waktu</label>
                                    <input type="time" class="form-control" placeholder="Masukkan nama Event"
                                        name="time" value="{{ $data->time }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" placeholder="Masukkan nama Event"
                                        name="date" value="{{ $data->date }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Lokasi</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="location" value="{{ $data->location }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Prefix</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="prefix" value="{{ $data->prefix }}" disabled />
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
                                    <label>Video</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="video" value="{{ $data->video }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Tipe<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="code" value="{{ $data->type }}"
                                        placeholder="Masukkan tipe kategori" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" name="description"
                                        value="{{ $data->description }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="status"
                                        value="{{ $data->status }}" placeholder="Masukkan tipe kategori" disabled />
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('event.index') }}" class="btn btn-secondary">Kembali</a>
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
