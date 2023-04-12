@extends('core.app')
@section('title', __('Buat Kategori Tipe Member'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Tipe Member</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Buat Kategori Tipe Member</h3>
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

                            <form method="POST" action="{{ route('members.member_type.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Tipe Member <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Masukkan Tipe Member"
                                        name="type" value="" required />
                                </div>
                                <div class="form-group">
                                    <label>File Logo Member<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            name="image" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>File Background Profil<span class="text-danger">*</span></label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            name="background" />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="code">Minimum Omset<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="code" name="min_omset"
                                        value="" placeholder="Masukkan jumlah minimum omset" />
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('members.member_type.index') }}"
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
