@extends('core.app')
@section('title', __('Ubah Kategori Notifikasi Pesan'))
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
                        <h3 class="card-label">Ubah Kategori Notifikasi Pesan</h3>
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

                            <form method="POST" action="{{ route('notification.update', $data->id) }}"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Kategori Notifikasi <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm filter" name="categories"
                                    placeholder="Type Here" required>
                                    <option selected disabled>Pilih Kategori</option>
                                    <option value="Semua" {{ $data->categories == 'Semua' ? 'selected' : ''}}>Semua</option>
                                    <option value="Affiliator" {{ $data->categories == 'Affiliator' ? 'selected' : ''}}>Affiliator</option>
                                    <option value="Affiliator Inti" {{ $data->categories == 'Affiliator Inti' ? 'selected' : ''}}>Affiliator Inti</option>
                                    <option value="Bronze" {{ $data->categories == 'Bronze' ? 'selected' : ''}}>Bronze</option>
                                    <option value="Gold" {{ $data->categories == 'Gold' ? 'selected' : ''}}>Gold</option>
                                    <option value="Platinum" {{ $data->categories == 'Platinum' ? 'selected' : ''}}>Platinum</option>
                                    <option value="Diamond" {{ $data->categories == 'Diamond' ? 'selected' : ''}}>Diamond</option>
                                </select>
                                </div>
                                <div class="form-group">
                                    <label>Notifikasi Pesan<span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="7" placeholder="Masukkan Notifikasi Pesan .." name="notification" value="" required>{{$data->notification}}</textarea>
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
