@extends('core.app')
@section('title', __('Detail Product Wishlist'))
@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Produk: Detail Produk Wishlist</h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Detail Produk Wishlist</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <form>
                                <div class="form-group row">
                                    <label class="col-12 col-form-label"><b>Gambar Produk Wishlist</b></label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-9">
                                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($product_data['picture'] as $product_datas)
                                                   <div class="carousel-item active">
                                                <img src="{{ asset($product_datas) }}" alt="First slide" width="300px" height="300px">
                                              </div>
                                              <div class="carousel-item">
                                                <img src="{{ asset($product_datas) }}" alt="Second slide" width="300px" height="300px">
                                              </div>
                                              <div class="carousel-item">
                                                <img src="{{ asset($product_datas) }}" alt="Third slide" width="300px" height="300px">
                                              </div>
                                                @endforeach

                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                              <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                              <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <form>
                                <div class="form-group row">
                                    <label class="col-12 col-form-label"><b>Detail Produk Wishlist</b></label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Nama Produk</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder=""
                                            name="" value="{{ $product_data['productName'] }}" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Harga Produk</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder=""
                                        name="" value="Rp.{{ $product_data['priceFormat'] }}" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Stok Produk</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" placeholder=""
                                        name="" value="{{ $product_data['stock'] }}" disabled />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Deskripsi Produk</label>
                                    <div class="col-9">
                                        <textarea class="form-control" placeholder="" rows="9"
                                        name="" value="{{ $product_data['description'] }}" disabled>{{ $product_data['description'] }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($product_data['isVariationActive'] === true)
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-12 col-form-label"><b>Detail Varian Produk Wishlist {{ $product_data['productName'] }}</b></label>
                                </div>
                                <div class="card-body"  name="event1">
                                    <table class="table table-striped table-head-custom table-checkable nowrap" id="myDIV">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Varian</th>
                                                <th>Stok</th>
                                                <th>Harga</th>
                                                <th>Berat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @php $no = 1; @endphp
                                                @foreach ($product_data['productVariationDescription'] as $item)
                                            </tr>
                                                    <td name="tdTable">{{ $no++ }}</td>
                                                    <td name="tdTable">{{ $item['name'] }}</td>
                                                    <td name="tdTable">{{ $item['stock'] }}</td>
                                                    <td name="tdTable">Rp. {{ $item['priceFormat'] }}</td>
                                                    <td name="tdTable">{{ $item['weight']}}</td>
                                            </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @else
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-12 col-form-label"><b>Tidak Ada Varian Produk Wishlist Untuk {{ $product_data['productName'] }}</b></label>
                                </div>
                            </div>
                            @endif


                            <div class="d-flex flex-row">
                                <div class="p-1">
                                    <a href="{{ url('/products/wishlist') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

