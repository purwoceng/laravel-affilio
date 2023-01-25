@extends('core.app')
@section('title', __('Detail Invoice Dibayar'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Konten: Invoice Dibayar</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Detail Invoice Dibayar</h3>
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

                            <form method="POST" action="{{ route('invoices.paid.show', ['id' => $data->id]) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nama <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan nama banner"
                                            name="username" value="{{ $data->username }}" disabled />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Code <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Code"
                                            name="code" value="{{ $data->code }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Subtotal <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Subtotal"
                                            name="subtotal" value="{{ $data->subtotal }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Ongkir <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Ongkir"
                                            name="shipping_cost" value="{{ $data->shipping_cost }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Total <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Total"
                                            name="total" value="{{ $data->total }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Metode Pembayaran <span
                                            class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Metode Pembayaran"
                                            name="payment_method" value="{{ $data->payment_method }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Type <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Type"
                                            name="type" value="{{ $data->type }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Status <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Status"
                                            name="status" value="{{ $data->status }}" disabled />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nomor Telp <span
                                            class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder="Masukkan Nomor Telp"
                                            name="whatsapp_number" value="{{ $data->whatsapp_number }}" disabled />
                                    </div>
                                </div>

                                <div class="d-flex flex-row">
                                    <div class="p-1">
                                        <a href="{{ route('invoices.paid.index') }}"
                                            class="btn btn-secondary">Kembali</a>
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
