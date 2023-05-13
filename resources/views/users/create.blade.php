@extends('core.app')
@section('title', __('Buat User'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Buat User</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Buat Kategori Buat User</h3>
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

                            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label>Nama<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Nama User"
                                        name="name" value="" required />
                                </div>
                                <div class="form-group">
                                    <label>Username<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Username"
                                        name="username" value="" required />
                                </div>
                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="Masukkan Email"
                                        name="email" value="" required />
                                </div>
                                <div class="form-group">
                                    <label>Password<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Masukkan Password"
                                        name="password" value="" required />
                                </div>
                                <div class="form-group">
                                    <label for="input-member-type-id">Role</label>
                                    <select name="roles"
                                        id="input-member-type-id"
                                        class="form-control"
                                        aria-describedby="member-type-helper"
                                        required>
                                        <option selected disabled value="0">Pilih Role User</option>
                                        @foreach ($roles as $data)
                                                            <option value="{{ $data->id }}">
                                                                {{ $data->label }}
                                                            </option>
                                                        @endforeach
                                    </select>

                                    @error('member_type_id')
                                        <small id="member-type-helper" class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('users.index') }}"
                                            class="btn btn-secondary">Kembali</a>
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
