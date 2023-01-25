@extends('core.app')
@section('title', __('Halaman Reset Password Member'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Reset Password</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Ubah Password Member</h3>
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
                    <form action="{{ route('members.reset-password.updatePassword', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="input-member-email">Email</label>
                            <input type="text" id="input-member-email" class="form-control" name="email"
                                value="{{ $data->email }}" aria-describedby="email-helper" disabled />
                        </div>
                        <div class="form-group">
                            <label for="input-member-password">Password</label>
                            <input type="text" id="input-member-password" class="form-control" name="password"
                                placeholder="Masukkan password baru" aria-describedby="password-helper" required />
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('members.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
