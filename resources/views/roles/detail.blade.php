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
                    <h3 class="card-title">Detail Peran</h3>
                    <hr />
                    <div class="row row--lined">
                        <div class="col-4 col-md-3">Nama</div>
                        <div class="col-8 col-md-9">: {{ $role->name }}</div>
                    </div>
                    <hr />
                    <div class="row row--lined">
                        <div class="col-4 col-md-3">Dibuat</div>
                        <div class="col-8 col-md-9">: {{ date('d-m-Y H:i', strtotime($role->created_at)) }}</div>
                    </div>
                    <hr />

                    <a href={{ route('roles.index') }} title="Kembali" class="btn btn-primary">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection