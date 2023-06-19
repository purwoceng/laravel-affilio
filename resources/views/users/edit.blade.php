@extends('core.app')
@section('title', __('Edit User'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Edit User</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Buat Kategori Edit User</h3>
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

                            <form method="POST" action="{{ route('users.update', $data->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label>Nama<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Nama User"
                                        name="name" value="{{$data->name}}"/>
                                </div>
                                <div class="form-group">
                                    <label>Username<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Username"
                                        name="username" value="{{$data->username}}" />
                                </div>
                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="Masukkan Email"
                                        name="email" value="{{$data->email}}"  />
                                </div>
                                {{-- <div class="form-group">
                                    <label>Password<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Masukkan Password"
                                        name="password" value="{{$data->password}}" required />
                                </div> --}}
                                <div class="form-group">
                                    <label>Role<span class="text-danger">*</span></label>
                                    @foreach ($data->getRoleNames() as $item)
                                        <input type="text" class="form-control" placeholder="Masukkan Password"
                                        name="password" value="{{$item}}" disabled />
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label>Permission<span class="text-danger"></span></label>
                                    @foreach ($data->getPermissionNames() as $permissions)
                                    <div class="form-check">
                                        <div class="checkbox">
                                        <label for="checkbox1" class="checkbox-bootstrap checkbox-lg ">
                                          <input type="checkbox" id="input-member-type-id" name="member_type_id[]" value="{{ $permissions }}" disabled checked> {{ $permissions }}
                                        </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label>Tambah Permission<span class="text-danger"></span></label>
                                    @foreach ($permission as $key=> $permissions)
                                    <div class="form-check">
                                        <div class="checkbox">
                                        <label for="checkbox1" class="form-check-label ">
                                          <input type="checkbox" id="input-member-type-id" name="permission[]" value="{{ $permissions->id }}"{{ $data->permissions->pluck('id')->contains($permissions->id) ? 'checked' : '' }}> {{ $permissions->name }}
                                        </label>
                                        </div>
                                    </div>
                                    @endforeach
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
