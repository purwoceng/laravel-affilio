@extends('core.app')
@section('title', __('Halaman Tidak Ditemukan'))

@push('css')
<style>
    .page_404{ padding:40px 0; background:#fff; font-family: 'Poppins', serif;
    }

    .page_404  img{ width:100%;}

    .four_zero_four_bg{

    background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
        height: 400px;
        background-position: center;
    }


    .four_zero_four_bg h1{
    font-size:80px;
    }

    .four_zero_four_bg h3{
                font-size:80px;
                }

                .link_404{
        color: #fff!important;
        padding: 10px 20px;
        background: #39ac31;
        margin: 20px 0;
        display: inline-block;}
        .contant_box_404{ margin-top:-50px;}
    </style>
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"></h5>
            </div>
        </div>
    </div>
    <center>
    <section class="page_404">
        <div class="container">
            <div class="row">
            <div class="col-sm-12 ">
            <div class="col-sm-10 col-sm-offset-1  text-center">
            <div class="four_zero_four_bg">
                <h1 class="text-center ">403</h1>


            </div>

            <div class="contant_box_404">
            <h3 class="h2">
            Anda Tidak Punya Akses Untuk Halaman Ini
            </h3>

            <a href="/" class="link_404">Go to Dashboard</a>
        </div>
            </div>
            </div>
            </div>
        </div>
    </section>
</center>

@endsection
