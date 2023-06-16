@extends('core.app')

@section('title', __($title))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{ $title }}</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Detail Pengguna</h3>
                    <hr />

                    @if (!empty($user->id))
                        <div class="row row--lined">
                            <div class="col-4 col-md-3">Nama</div>
                            <div class="col-8 col-md-9">: {{ $user->name }}</div>
                        </div>
                        <hr />
                        <div class="row row--lined">
                            <div class="col-4 col-md-3">Username</div>
                            <div class="col-8 col-md-9">: {{ $user->username }}</div>
                        </div>
                        <hr />
                        <div class="row row--lined">
                            <div class="col-4 col-md-3">Email</div>
                            <div class="col-8 col-md-9">: {{ $user->email }}</div>
                        </div>
                        <hr/>
                        <div class="row row--lined">
                            <div class="col-4 col-md-3">Role</div>
                            @foreach ($user->getRoleNames() as $role)
                                 <div class="col-8 col-md-9">: {{ $role }}</div>
                            @endforeach
                        </div>
                        <hr />
                        <div class="row row--lined">
                            <div class="col-4 col-md-3">Permissions</div>
                            @foreach ($user->getPermissionNames() as $permissions)
                                 <div class="form-check">
                                    <div class="checkbox">
                                    <label for="checkbox1" class="checkbox-bootstrap checkbox-lg ">
                                      <input type="checkbox" id="input-member-type-id" name="member_type_id[]" value="{{ $permissions }} :" disabled checked> {{ $permissions }}
                                    </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr />
                    @else
                        <h3>Pengguna Tidak Ditemukan</h3>
                        <p>Data yang Anda cari mungkin tidak ditemukan atau telah dihapus</p>
                    @endif

                    <a href={{ route('users.index') }} title="Kembali" class="btn btn-primary">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
