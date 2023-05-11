@extends('core.app')
@section('title', __('Detail Member'))
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
                        <h3 class="card-label">Detail Member</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <form>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nama</label>
                                    <div class="col-9"><span>{{ $data->name }}</span></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Username</label>
                                    <div class="col-9"><span>{{ $data->username }}</span></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Email</label>
                                    <div class="col-9"><span>{{ $data->email }}</span></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nomor Telepon / HP</label>
                                    <div class="col-9"><span>{{ $data->phone }}</span></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Tipe Member</label>
                                    <div class="col-9"><span>{{ $data->member_type->type }}</span></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Referral</label>
                                    <div class="col-9"><span>{{ $data->referral }}</span></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Terverifikasi</label>
                                    <div class="col-9">
                                        @if ($data->is_verified == 1)
                                            <span
                                                class="label label-light-success label-inline label-bold">Terverifikasi</span>
                                        @else
                                            <span class="label label-light-danger label-inline label-bold">Belum
                                                Diverifikasi</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Status</label>
                                    <div class="col-9">
                                        @if ($data->is_blocked == 1)
                                            <span class="label label-light-danger label-inline label-bold">Diblokir</span>
                                        @else
                                            <span class="label label-light-success label-inline label-bold">Aktif</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Role Transaction</label>
                                    <div class="col-9">
                                        @if ($data->is_transaction == 1)
                                            <span class="label label-light-success label-inline label-bold">Aktif</span>
                                        @else
                                            <span class="label label-light-danger label-inline label-bold">Non-Active</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Foto</label>
                                    <div class="col-9">
                                        @if ($data->image)
                                            <div
                                                style="width: 150px;
                                                height: 150px;
                                                border-radius: 8px;
                                                border: 1px solid #ebebeb;
                                                display: flex;
                                                align-items: center;
                                                position: relative;">
                                                <a href="{{ config('app.s3_url') . $data->image }}"
                                                    style="position: absolute; z-index: 1; top: 0; bottom: 0; left: 0; right: 0;"
                                                    target="_blank"></a>
                                                <img src="{{ config('app.s3_url') . $data->image }}?w=150"
                                                    alt="{{ $data->name }}"
                                                    style="display: block; width: 100%; margin: 0 auto;" />
                                            </div>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('members.index') }}" class="btn btn-secondary">Kembali</a>
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
