@extends('core.app')
@section('title', __('Pengaturan Profile User'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Pengaturan Profile User</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Pengaturan Profile User</h3>
                    </div>
                </div>
                @if (session('error'))
                <span class="alert alert-danger my-3 mx-4" role="alert">
                    Oops - {{ session('error') }}
                </span>
                @endif
                @if (session('success'))
                    <span class="alert alert-success my-3 mx-4" role="alert">
                        {{ session('success') }}
                    </span>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form method="POST" action="{{ route('profile.update', $data->id) }}"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="col-3 col-form-label">Nama User</label>
                                    <div class="form-group">
                                        <input class="form-control"
                                        name="name" value="{{ $data->name }}"></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-3 col-form-label">Email User</label>
                                    <div class="form-group">
                                        <input class="form-control"
                                        name="" value="{{ $data->email }}" ></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-3 col-form-label">Username User</label>
                                    <div class="form-group">
                                        <input class="form-control"
                                        name="username" value="{{ $data->username }}" ></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-3 col-form-label">Password Baru</label>
                                    <div>
                                        <input type="password" id="input-member-password" class="form-control" name="password"
                                            placeholder="Masukkan password baru" aria-describedby="password-helper"  />
                                    </div>
                                </div>
                                <div class="d-flex flex-row">
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
