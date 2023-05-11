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
                                    <label for="input-member-type-id">Tipe Member</label>
                                    <select name="member_type_id"
                                        id="input-member-type-id"
                                        class="form-control"
                                        aria-describedby="member-type-helper"
                                        required disabled>
                                        <option selected disabled value="0">Pilih Tipe Member</option>

                                        @foreach ($member_types as $key => $member_type)
                                            <option
                                                value="{{ $member_type->id }}"
                                                {{ $data->member_type_id == $member_type->id ? 'selected' : '' }}>
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
                                    <label class="col-3 col-form-label">Judul Notifikasi</label>
                                    <div class="form-group">
                                        <input class="form-control" rows="7"
                                        name="" value="{{ $data->title }}" disabled></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-3 col-form-label">Deskripsi Notifikasi</label>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="7"
                                        name="" value="{{ $data->description }}" disabled>{{ $data->description }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-is-active">Kreator Pesan Notifikasi</label>
                                    <select name="creator_id" id="input-is-active" class="form-control"
                                        aria-describedby="is-active-helper" required disabled>
                                        <option value="0" {{ $data->creator_id == '0' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="1" {{ $data->creator_id == '1' ? 'selected' : '' }}>
                                            Mentor
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
