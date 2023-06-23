@hasanyrole('super_user')
@extends('core.app')
@section('title', __('Edit Member'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Data Member</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Edit Member</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success my-3 mx-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger my-3 mx-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    <form action="{{ route('members.update', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="input-member-name">Nama*</label>
                            <input type="text" id="input-member-name" class="form-control" name="name"
                                value="{{ $data->name }}" aria-describedby="name-helper" required />

                            @error('name')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-username">Username*</label>
                            <input type="text" id="input-member-username" class="form-control" name="username"
                                value="{{ $data->username }}" aria-describedby="username-helper" required />

                            @error('username')
                                <small id="username-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-email">Email*</label>
                            <input type="text" id="input-member-email" class="form-control" name="email"
                                value="{{ $data->email }}" aria-describedby="email-helper" required />

                            @error('email')
                                <small id="email-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-phone">Nomor Telepon / HP*</label>
                            <input type="text" id="input-member-phone" class="form-control" name="phone"
                                value="{{ $data->phone }}" aria-describedby="phone-helper" required />

                            @error('phone')
                                <small id="phone-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-type-id">Tipe Member*</label>
                            <select name="member_type_id" id="input-member-type-id" class="form-control"
                                aria-describedby="member-type-helper" required>
                                <option selected disabled value="0">Pilih Tipe Member</option>

                                @foreach ($member_types as $key => $member_type)
                                    <option value="{{ $member_type->id }}"
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
                            <label for="input-member-referral">Referral*</label>
                            <input type="text" id="input-member-referral" class="form-control" name="referral"
                                value="{{ $data->referral }}" aria-describedby="referral-helper" disabled />

                            @error('referral')
                                <small id="referral-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-verified">Status Verifikasi</label>
                            <select name="is_verified" id="input-is-verified" class="form-control"
                                aria-describedby="is-verified-helper" required>
                                <option selected disabled value="3">Pilih Status Verifikasi</option>
                                <option value="1" {{ $data->is_verified == '1' ? 'selected' : '' }}>
                                    Verifikasi
                                </option>
                                <option value="0" {{ $data->is_verified == '0' ? 'selected' : '' }}>
                                    Belum-Verifikasi
                                </option>
                            </select>

                            @error('is_verified')
                                <small id="is-verified-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-active">Status Founder</label>
                            <select name="is_founder" id="input-is-active" class="form-control"
                                aria-describedby="is-active-helper" required>
                                <option selected disabled value="3">Pilih Status Founder</option>
                                <option value="1" {{ $data->is_founder == '1' ? 'selected' : '' }}>
                                    Founder
                                </option>
                                <option value="0" {{ $data->is_founder == '0' ? 'selected' : '' }}>
                                    Bukan-Founder
                                </option>
                            </select>

                            @error('is_active')
                                <small id="is-active-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-transaction">Role Transaction</label>
                            <select name="is_transaction" id="input-is-transaction" class="form-control"
                                aria-describedby="is-transaction-helper" required>
                                <option selected disabled value="3">Pilih Role Transaksi</option>
                                <option value="1" {{ $data->is_transaction == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ $data->is_transaction == '0' ? 'selected' : '' }}>
                                    Non-Active
                                </option>
                            </select>

                            @error('is_transaction')
                                <small id="is-transaction-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-blocked">Akun Blocked</label>
                            <select name="is_blocked" id="input-is-blocked" class="form-control"
                                aria-describedby="is-blocked-helper" required>
                                <option selected disabled value="3">Pilih Status Block</option>
                                <option value="1" {{ $data->is_blocked == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ $data->is_blocked == '0' ? 'selected' : '' }}>
                                    Non-Active
                                </option>
                            </select>

                            @error('is_transaction')
                                <small id="is-transaction-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-image">Gambar</label>
                            <input type="file" accept=".jpg, .jpeg, .png" class="form-control"
                                aria-describedby="image-helper" name="image" />

                            @error('image')
                                <small id="image-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('members.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@else
@section('title', __('Edit Member'))

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Data Member</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Edit Member (Customer Service)</h3>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success my-3 mx-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger my-3 mx-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif


                    <form action="{{ route('members.updatecs', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="input-member-name">Nama*</label>
                            <input type="text" id="input-member-name" class="form-control" name="name"
                                value="{{ $data->name }}" aria-describedby="name-helper" required />

                            @error('name')
                                <small id="name-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-username">Username*</label>
                            <input type="text" id="input-member-username" class="form-control" name="username"
                                value="{{ $data->username }}" aria-describedby="username-helper" required />

                            @error('username')
                                <small id="username-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-email">Email*</label>
                            <input type="text" id="input-member-email" class="form-control" name="email"
                                value="{{ $data->email }}" aria-describedby="email-helper" required />

                            @error('email')
                                <small id="email-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-phone">Nomor Telepon / HP*</label>
                            <input type="text" id="input-member-phone" class="form-control" name="phone"
                                value="{{ $data->phone }}" aria-describedby="phone-helper" required />

                            @error('phone')
                                <small id="phone-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-member-type-id">Tipe Member*</label>
                            <select name="member_type_id" id="input-member-type-id" class="form-control"
                                aria-describedby="member-type-helper" required disabled>
                                <option selected disabled value="0">Pilih Tipe Member</option>

                                @foreach ($member_types as $key => $member_type)
                                    <option value="{{ $member_type->id }}"
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
                            <label for="input-member-referral">Referral*</label>
                            <input type="text" id="input-member-referral" class="form-control" name="referral"
                                value="{{ $data->referral }}" aria-describedby="referral-helper" disabled />

                            @error('referral')
                                <small id="referral-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-verified">Status Verifikasi</label>
                            <select name="is_verified" id="input-is-verified" class="form-control"
                                aria-describedby="is-verified-helper" required>
                                <option selected disabled value="3">Pilih Status Verifikasi</option>
                                <option value="1" {{ $data->is_verified == '1' ? 'selected' : '' }}>
                                    Verifikasi
                                </option>
                                <option value="0" {{ $data->is_verified == '0' ? 'selected' : '' }}>
                                    Belum-Verifikasi
                                </option>
                            </select>

                            @error('is_verified')
                                <small id="is-verified-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-active">Status Founder</label>
                            <select name="is_founder" id="input-is-active" class="form-control"
                                aria-describedby="is-active-helper" required disabled>
                                <option selected disabled value="3">Pilih Status Founder</option>
                                <option value="1" {{ $data->is_founder == '1' ? 'selected' : '' }}>
                                    Founder
                                </option>
                                <option value="0" {{ $data->is_founder == '0' ? 'selected' : '' }}>
                                    Bukan-Founder
                                </option>
                            </select>

                            @error('is_active')
                                <small id="is-active-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-transaction">Role Transaction</label>
                            <select name="is_transaction" id="input-is-transaction" class="form-control"
                                aria-describedby="is-transaction-helper" required disabled>
                                <option selected disabled value="3">Pilih Role Transaksi</option>
                                <option value="1" {{ $data->is_transaction == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ $data->is_transaction == '0' ? 'selected' : '' }}>
                                    Non-Active
                                </option>
                            </select>

                            @error('is_transaction')
                                <small id="is-transaction-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-is-blocked">Akun Blocked</label>
                            <select name="is_blocked" id="input-is-blocked" class="form-control"
                                aria-describedby="is-blocked-helper" required>
                                <option selected disabled value="3">Pilih Status Block</option>
                                <option value="1" {{ $data->is_blocked == '1' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ $data->is_blocked == '0' ? 'selected' : '' }}>
                                    Non-Active
                                </option>
                            </select>

                            @error('is_transaction')
                                <small id="is-transaction-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="input-image">Gambar</label>
                            <input type="file" accept=".jpg, .jpeg, .png" class="form-control"
                                aria-describedby="image-helper" name="image" />

                            @error('image')
                                <small id="image-helper" class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <a class="btn btn-outline-danger" href="{{ route('members.index') }}">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@endhasanyrole



