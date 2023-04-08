@extends('core.app')
@section('title', __('Ubah Kategori Gambar Supplier'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Kategori Gambar Supplier</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Ubah Kategori Gambar Supplier</h3>
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

                            <form method="POST" action="{{ route('supplierscover.update', $data->id) }}"  enctype="multipart/form-data">
                                {{csrf_field()}}
                                {{method_field('put')}}
                                <div class="form-group">
                                    <label>Gambar Thumbnail<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" placeholder="Masukkan Gambar Thumbnail"
                                        name="image" value=""  />
                                </div>
                                <div class="col-4">
                                    <img src="{{ config('app.s3_url') . $data->image }}" class="img-fluid"
                                        width="150px">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="input-is-active">Status</label>
                                    <select name="is_active" id="input-is-active" class="form-control"
                                        aria-describedby="is-active-helper" required>
                                        <option value="1" {{ $data->is_active == '1' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="0" {{ $data->is_active == '0' ? 'selected' : '' }}>
                                            Non-aktif
                                        </option>
                                    </select>

                                    @error('is_active')
                                        <small id="is-active-helper" class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                               <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('supplierscover.index') }}"
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
