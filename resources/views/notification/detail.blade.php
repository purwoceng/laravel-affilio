@extends('core.app')
@section('title', __('Detail Notifikasi Pesan'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Detail Notifikasi Pesan</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Notifikasi Pesan</h3>
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

                            <form method="POST" action="{{ route('notification.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Kategori Notifikasi <span class="text-danger"></span></label>
                                    <div class="form-group">
                                        <input type="textarea" class="form-control" rows="9"
                                            name="header" value="{{ $data->categories }}" disabled />
                                    </div>
                                </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Notifikasi</label>
                                        <textarea class="form-control" rows="7"
                                        name="" value="{{ $data->notification }}" disabled>{{ $data->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kreator Pesan<span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm filter" name="creator_id"
                                    placeholder="Type Here" required disabled>
                                    <option selected disabled>Pilih Kreator Pesan</option>
                                    <option value="0" {{ $data->creator_id == '0' ? 'selected' : ''}}>Admin</option>
                                    <option value="1" {{ $data->categories == '1' ? 'selected' : ''}}>Mentor</option>
                                </select>
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('notification.index') }}"
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
