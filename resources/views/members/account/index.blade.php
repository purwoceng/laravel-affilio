@extends('core.app')
@section('title', __('Data Rekening Member'))
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Member</h5>
            </div>

           

        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Data Rekening Member</h3>
                    </div>

                    <div class="js-action mt-2 mb-4">
                        <div class="d-flex flex-row">
                            <div class="btn-group">
                                <div class="m-1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success  excel" data-toggle="modal">
                                        <i class="fas fa-download fa-sm mr-1 excel"></i>@lang('Export Excel')
                                    </a>
                                </div>
                            </div>
                        </div>
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

                    <table id="js-table-member-account"
                        class="table table-separate table-head-custom table-hover table-striped table-checkable nowrap"
                        style="width:100%">
                        <thead>
                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Username</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="username" placeholder="Type Here">
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nama</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="account_name" placeholder="Type Here">
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Email</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="email" placeholder="Type Here">
                                                </div>
                                            </div>

                                            

                                        </div>
                                        <div class="col-md-6">
                                            
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nomor Rekening</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="account_number" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Bank</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select class="form-control form-control-sm filter" data-name="bank_name"
                                                        placeholder="Type Here">
                                                        <option disabled selected>Pilih Bank</option>
                                                        <option value="all">Semua</option>
                                                        <option value="Bank Central Asia">BCA</option>
                                                        <option value="Bank Rakyat Indonesia">BRI</option>
                                                        <option value="Bank Syariah Indonesia">BSI</option>
                                                        <option value="Bank Negara Indonesia">BNI</option>
                                                        <option value="Bank Nasional Indonesia">BNsI</option>
                                                        <option value="Bank Mandiri">Mandiri</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Status Rekening</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select class="form-control form-control-sm filter" data-name="publish"
                                                        placeholder="Type Here">
                                                        <option disabled selected>Pilih Status Rekening</option>
                                                        <option value="all">Semua</option>
                                                        <option value="1">Sudah</option>
                                                        <option value="0">Belum</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <tr class="text-center small">
                                <th>#</th>
                                <th>Username</th>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Rekening</th>
                                <th>Email</th>
                                <th>Verifikasi</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('orders.partials.modal')
@endsection


@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helpers/order-helper.js') }}"></script>
    <script>
        $(document).ready(function() {
            const urlAjax = "{{ route('members.accounts.index') }}";

            var tableMemberAccount = $('#js-table-member-account').DataTable({
                destroy: true,
                responsive: false,
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                autoWidth: true,
                select: true,
                language: {
                    infoFiltered: "",
                },
                lengthChange: false,
                pageLength: 50,
                order: [
                    [0, 'DESC']
                ],
                ajax: {
                    url: urlAjax,
                    type: 'GET',
                },
                scrollX: true,
                columns: [{
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'username',
                        name: 'username',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'bank_name',
                        name: 'bank_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'account_number',
                        name: 'account_number',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'account_name',
                        name: 'account_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'email',
                        name: 'email',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'publish',
                        name: 'publish',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.publish) {
                                return '<span class="label label-light-success label-inline label-bold">Sudah</span>';
                            } else {
                                return '<span class="label label-light-danger label-inline label-bold">Belum</span>';
                            }
                        }
                    },
                    // {
                    //     data: 'actions',
                    //     name: 'actions',
                    //     sortable: false,
                    //     orderable: false,
                    //     searchable: false,
                    //     className: 'text-lg-center text-center small',
                    //     render: function(data, type, row, meta) {
                    //         let elements = '';

                    //         if (row.publish) {
                    //             elements += '<span class="text-center">-</span>';
                    //         } else {
                    //             elements += `
                    //             <div class="dropdown dropdown-inline">
                    //                 <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-icon" data-toggle="dropdown">
                    //                     <i class="la la-cog"></i>
                    //                 </a>
                    //                 <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    //                     <ul class="nav nav-hoverable flex-column">
                    //                         <li class="nav-item">
                    //                             <a class="nav-link js-activation-account" href="javascript:void(0)" data-id="${row.id}">
                    //                                 <span class="nav-text" data-id="${row.id}">Verifikasi</span>
                    //                             </a>
                    //                         </li>
                    //                     </ul>
                    //                 </div>
                    //             </div>
                    //             `;
                    //         }

                    //         return elements;
                    //     }
                    // }

                ],
            });


            function getDataFiltered() {
                let filterEl = $('.filter');
                let data = {};

                $.each(filterEl, function(i, v) {
                    let key = $(v).data('name');
                    let value = $(v).val();
                    if (key == 'date') {
                        if (value != '') {
                            value = value.split('/');
                            data[key] = JSON.stringify(value);
                        }
                    } else {
                        if (value != '') {
                            data[key] = value;
                        }
                    }
                });

                if (getURLVar('start')) {
                    data.start = getURLVar('start');
                }

                if (getURLVar('limit')) {
                    data.limit = getURLVar('limit');
                }

                reDrawTable(data);
            };

            function getFullUrl(data) {
                let
                    url = urlAjax,
                    params = '';

                $.each(data, function(key, value) {
                    if (!!value) {
                        params += `${key}=${value}&`;
                    }
                });

                params = params.replace(/\&$/, '');

                if (params != '') {
                    url = `${url}?${params}`;
                }
                return url;
            };

            function reDrawTable(data) {
                tableMemberAccount.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }

            $(document).on('click', '.js-activation-account', function(e) {

                swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Anda akan melakukan verifikasi rekening ini!",
                    showCancelButton: true,
                    showConfirmButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Iya",
                    cancelButtonText: "Batal",
                }).then(function(result) {
                    if (result.value) {
                        Swal.fire({
                            showCloseButton: false,
                            showConfirmButton: false,
                            icon: 'info',
                            title: 'Harap Tunggu',
                            text: 'Sedang meneruskan pesanan Anda...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            onBeforeOpen: function() {
                                Swal.showLoading();
                            },
                        });
                        setTimeout(function() {
                            let urlActivation =
                                "{{ route('members.accounts.verification') }}";
                            let memberId = $(e.target).data('id');
                            $.ajax({
                                type: "POST",
                                url: urlActivation,
                                data: {
                                    id: memberId,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.icon,
                                        title: response.title,
                                        text: response.message,
                                    });

                                    getDataFiltered();
                                }
                            });

                        }, 500);
                    } else if (result.dismiss === 'Batal') {
                        console.log('Batal')
                    }

                });
            });
            
             //exportexcel
             let excelModal = $('#js-detail-modal');
            $(document).on("click", ".excel", function(e) {
                let elementHTML = `

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bank</label>
                    <div class="col-sm-10">
                        <select class="form-control form-control-sm filter" data-name="bank" id="bank"
                                        id="input-bank-name"
                                        class="form-control"
                                        aria-describedby="bank-name-helper"
                                        required>
                                        <option selected disabled value="0">Pilih Bank Name</option>
                                        <option selected  value="all">Semua</option>
                                        <option selected  value="Bank Central Indonesia">BCA</option>
                                        <option selected  value="Bank Rakyat Indonesia">BRI</option>
                                        <option selected  value="Bank Syariah Indonesia">BSI</option>
                                        <option selected  value="Bank Negara Indonesia">BNI</option>
                                        <option selected  value="Bank Mandiri">Mandiri</option>
                                       
                                    </select>

                                    @error('bank')
                                        <small id="bank-name-helper" class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                    </div>
                </div>
            `;
            let elementFooter = `
                        <button type="submit" class="btn btn-light-success font-weight-bold" id="submitexcel">Export</button>
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button> </form>
                        `;

                excelModal.find(".modal-title").html('Input Export Excel Member');
                excelModal.find(".modal-body").html(elementHTML);
                excelModal.find(".modal-footer").html(elementFooter);
                excelModal.modal('show');

            });

            //button export
            $(document).on('click', '#submitexcel', function() {
                // var date_range1 = $("#date_range1").val();
                var bank = $("#bank").val();
                var x = document.getElementById("submitexcel");
                x.disabled = true;
                var xhr = $.ajax({
                    type: 'GET',
                    url: "{{ route('members.accounts.exportexcel') }}",
                    data: {
                        // "daterange1": date_range1,
                        "bank": bank
                    },
                    cache: false,
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 2) {
                                if (xhr.status == 200) {
                                    xhr.responseType = "blob";
                                } else {
                                    xhr.responseType = "text";
                                }
                            }
                        };
                        return xhr;
                    },
                    success: function(data) {
                        const url = window.URL || window.webkitURL;
                        const downloadURL = url.createObjectURL(data);
                        var a = $("<a />");
                        a.attr("download", 'Daftar Data Member-' + bank + '.xlsx');
                        a.attr("href", downloadURL);
                        $("body").append(a);
                        a[0].click();
                        $("body").remove(a);
                    }
                });
            });
          
        });
    </script>
@endpush
