@extends('core.app')
@section('title', __('Edit Member Blokir'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Data Member Blokir</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Edit Member Blokir</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <span class="alert alert-danger my-3 mx-4" role="alert">
                            Oops - {{ session('error') }}
                        </span>
                    @endif

                    <form action="{{ route('members.blocked.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('put')}}

                        <div class="form-group">
                            <label for="input-member-name">Nama*</label>
                            <input type="text"
                                id="input-member-name"
                                class="form-control"
                                name="name"
                                value="{{ $data->name }}"
                                aria-describedby="name-helper"
                                required
                            />

                            @error('name')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-username">Username*</label>
                            <input type="text"
                                id="input-member-username"
                                class="form-control"
                                name="username"
                                value="{{ $data->username }}"
                                aria-describedby="username-helper"
                                required
                            />

                            @error('username')
                                <small id="username-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-email">Email*</label>
                            <input type="email"
                                id="input-member-email"
                                class="form-control"
                                name="email"
                                value="{{ $data->email }}"
                                aria-describedby="email-helper"
                                required
                            />

                            @error('email')
                                <small id="email-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-phone">Nomor Telepon / HP*</label>
                            <input type="text"
                                id="input-member-phone"
                                class="form-control"
                                name="phone"
                                value="{{ $data->phone }}"
                                aria-describedby="phone-helper"
                                required
                            />

                            @error('phone')
                                <small id="phone-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-type-id">Tipe Member*</label>
                            <select name="member_type_id"
                                id="input-member-type-id"
                                class="form-control"
                                aria-describedby="member-type-helper"
                                required>
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
                        {{-- <div class="form-group">
                            <label for="input-image">Gambar</label>
                            <input type="file"
                                accept=".jpg, .jpeg, .png"
                                class="form-control"
                                aria-describedby="image-helper"
                                name="image"
                            />

                            @error('image')
                                <small id="image-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div> --}}

                        <a class="btn btn-outline-danger" href="{{ route('members.blocked.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
