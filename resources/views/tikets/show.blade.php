@extends('core.app')
@section('title', __('Detail Tiket'))
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
                        <h3 class="card-label">Detail Tiket</h3>
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

                            <form method="POST" action="{{ route('tiket.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Tiket</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="name" value="{{ $data->name }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Kuota</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="kuota" value="{{ $data->kuota }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Harga Tiket</label>
                                    <input type="text" class="form-control" placeholder="Masukkan nama Event"
                                        name="price" value="{{ $data->price }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Dimulai</label>
                                    <input type="date" class="form-control" placeholder="Masukkan nama Event"
                                        name="start" value="{{ $data->start }}" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Berakhir</label>
                                    <input type="date" class="form-control" placeholder="Masukkan nama Event"
                                        name="finish" value="{{ $data->finish }}" disabled />
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('tiket.index') }}" class="btn btn-secondary">Kembali</a>
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
