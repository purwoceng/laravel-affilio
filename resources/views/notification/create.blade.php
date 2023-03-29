@extends('core.app')
@section('title', __('Buat Kategori Notifikasi Pesan'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Notifikasi Pesan</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Buat Kategori Notifikasi Pesan</h3>
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
                                    <label>Kategori Notifikasi <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm filter" name="categories"
                                    placeholder="Type Here">
                                    <option disabled selected>Pilih Kategori Notifikasi</option>
                                    <option value="Semua">Semua</option>
                                    <option value="Affiliator">Affiliator</option>
                                    <option value="Affiliator Inti">Affiliator Inti</option>
                                    <option value="Bronze">Bronze</option>
                                    <option value="Gold">Gold</option>
                                    <option value="Platinum">Platinum</option>
                                    <option value="Diamond">Diamond</option>
                                </select>
                                </div>
                                <div class="form-group">
                                    <label>Notifikasi Pesan<span class="text-danger"></span></label>
                                    <textarea class="form-control" rows="7" placeholder="Masukkan Notifikasi Pesan .." name="description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kreator Pesan <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm filter" name="creator_id"
                                    placeholder="Type Here">
                                    <option disabled selected>Pilih Kreator Pesan</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Mentor</option>
                                </select>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('notification.index') }}"
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
