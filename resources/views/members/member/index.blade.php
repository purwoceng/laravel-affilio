@extends('core.app')
@section('title', __('Data Member'))
@push('css')
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

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
                        <h3 class="card-label">Data Member</h3>
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

                    <table id="js-table-all-member"
                        class="table table-separate table-head-custom table-hover table-striped table-checkable nowrap"
                        style="width:100%">
                        <thead>
                            <div class="filter-wrapper">
                                <form action="#" class="form" id="filter">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Nama</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="name" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Username</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="username" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">No HP</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="phone" placeholder="Type Here">
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Tipe Member</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select type="text" class="form-control form-control-sm filter"
                                                        data-name="member_type" placeholder="Type Here">
                                                        <option disabled>Pilih Tipe Member</option>
                                                        <option value="all" selected default>Semua</option>
                                                        @foreach ($member_type as $data)
                                                            <option value="{{ $data->id }}">{{ $data->type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Status Founder</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select type="text" class="form-control form-control-sm filter"
                                                        data-name="is_founder" placeholder="Type Here">
                                                        <option disabled>Pilih Status Founder</option>
                                                        <option value="all" selected default>Semua</option>
                                                        <option value="1">Founder</option>
                                                        <option value="0">Bukan Founder</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Email</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="email" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Referral</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input type="text" class="form-control form-control-sm filter"
                                                        data-name="referral" placeholder="Type Here">
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Kota</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <input id="select_city" type="text"
                                                        class="form-control form-control-sm filter" data-name="city_name"
                                                        placeholder="Type Here">
                                                </div>
                                            </div>


                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label"> Verifikasi</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select type="text" class="form-control form-control-sm filter"
                                                        data-name="is_verified" placeholder="Type Here">
                                                        <option disabled>Pilih Status Verifikasi</option>
                                                        <option value="all" selected default>Semua</option>
                                                        <option value="1">Verifikasi</option>
                                                        <option value="0">Belum Verifikasi</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-sm row">
                                                <label class="col-4 col-form-label">Role Transaksi</label>
                                                <div
                                                    class="col-8 d-flex flex-row justify-content-center align-items-center">
                                                    <select type="text" class="form-control form-control-sm filter"
                                                        data-name="is_transaction" placeholder="Type Here">
                                                        <option disabled>Pilih Role Transaksi</option>
                                                        <option value="all" selected default>Semua</option>
                                                        <option value="1">Transaksi</option>
                                                        <option value="0">Non-Transaksi</option>
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
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Email</th>
                                <th>Tipe Member</th>
                                <th>Referral</th>
                                <th>Status Founder</th>
                                <th>Alamat Member</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>Verifikasi</th>
                                <th>Status</th>
                                <th>Role Transaction</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helpers/order-helper.js') }}"></script>
    <script>
        $(document).ready(function() {
            const urlAjax = "{{ route('members.index') }}";
            const urlAjaxCity = "{{ route('city.index') }}";

            var tableAllMember = $('#js-table-all-member').DataTable({
                pagingType: 'full_numbers',
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                autoWidth: true,
                select: true,
                language: {
                    infoFiltered: "",
                },
                lengthMenu: [
                    [50, 100, 200, 300, 400, 500, 1000],
                    [50, 100, 200, 300, 400, 500, 1000]
                ],
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
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
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
                        data: 'member_type',
                        name: 'member_type',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'referral',
                        name: 'referral',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'is_founder',
                        name: 'is_founder',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_founder === '1') {
                                return '<span class="label  label-light-success label-inline label-bold">Founder</span>';
                            } else {
                                return '<span>-</span>';
                            }
                        }
                    },
                    {
                        data: 'address',
                        name: 'address',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'city_name',
                        name: 'city_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'province_name',
                        name: 'province_name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                    },
                    {
                        data: 'is_verified',
                        name: 'is_verified',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_verified) {
                                return '<span class="label  label-light-success label-inline label-bold">Sudah</span>';
                            } else {
                                return '<span class="label  label-light-danger label-inline label-bold">Belum</span>';
                            }
                        }
                    },
                    {
                        data: 'is_blocked',
                        name: 'is_blocked',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_blocked) {
                                return ' <span class="label  label-light-danger label-inline label-bold">Blocked</span>';
                            } else {
                                return '<span class="label  label-light-success label-inline label-bold">Active</span>';
                            }
                        }
                    },
                    {
                        data: 'is_transaction',
                        name: 'is_transaction',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            if (row.is_transaction === '1') {
                                return '<span class="label  label-light-success label-inline label-bold">Aktif</span>';
                            } else {
                                return '<span class="label label-light-danger label-inline label-bold">Non-Active</span>';
                            }
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-left text-center small',
                        render: function(data, type, row, meta) {
                            let elements = '';

                            elements += `
                                <div class="mr-3">
                                    <a class="btn btn-sm btn-success btn-icon" href="${urlAjax}/detail/${row.id}" title="Detail Member">
                                    <i class="fas fa-eye mr-1 fa-sm"></i>
                                    </a>
                                    <a class="btn btn-sm btn-primary btn-icon" href="${urlAjax}/network/${row.id}" title="Jaringan Member">
                                    <i class="fas fa-network-wired mr-1 fa-sm"></i>
                                    </a>
                                    <a class="btn btn-sm btn-warning btn-icon" href="${urlAjax}/edit/${row.id}" title="Edit Member">
                                    <i class="fas fa-edit mr-1 fa-sm"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger btn-icon" href="${urlAjax}/reset-password/${row.id}" title="Reset Password">
                                    <i class="fas fa-key mr-1 fa-sm"></i>
                                    </a>
                                    <a class="btn btn-sm btn-info btn-icon" href="${urlAjax}/reset-pin/${row.id}" title="Ganti PIN">
                                    <i class="fas fa-money-check mr-1 fa-sm"></i>
                                    </a>

                                </div>`;

                            return elements;
                        }
                    }

                ],
            });

            //exportexcel
            // let excelModal = $('#js-detail-modal');
            // $(document).on("click", ".excel", function(e) {
            //     let elementHTML = `
        //         <div class="form-group row">
        //             <label for="js-daterange-picker1" class="col-sm-2 col-form-label">Tipe Member</label>
        //                 <div class="col-sm-10">
        //                     <div class='input-group' id='js-daterange-picker'>
        //                         <input type='text' class="form-control filter"
        //                                 id="date_range1" name="date_range1" placeholder="Select date range" />
        //                             <div class="input-group-append">
        //                                 <span class="input-group-text">
        //                                     <i class="la la-calendar-check-o"></i>
        //                                 </span>
        //                             </div>
        //                     </div>
        //                 </div>
        //         </div>
        //         <div class="form-group row">
        //             <label class="col-sm-2 col-form-label">Tipe Member</label>
        //             <div class="col-sm-10">
        //                 <select class="form-control form-control-sm filter" data-name="type_member" id="type_member"
        //                                     placeholder="Type Here">
        //                                     <option disabled >Pilih Status Order</option>
        //                                     <option value="all" selected>Semua</option>
        //                                     <option value="1">Affliator</option>
        //                                     <option value="2">Affliator Inti</option>
        //                                     <option value="3">Bronze</option>
        //                                     <option value="4">Gold</option>
        //                                     <option value="5">Platinum</option>
        //                                     <option value="6">Diamond</option>
        //                                     </select>
        //             </div>
        //         </div>


        //     `;


            //     let elementFooter = `
        //                 <button type="submit" class="btn btn-light-success font-weight-bold" id="submitexcel">Export</button>
        //                 <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button> </form>
        //                 `;

            //     excelModal.find(".modal-title").html('Input Export Excel');
            //     excelModal.find(".modal-body").html(elementHTML);
            //     excelModal.find(".modal-footer").html(elementFooter);
            //     excelModal.modal('show');

            // });

            // //js datepicker excel
            // $('#js-detail-modal').on('shown.bs.modal', function(e) {
            //     $('input[name="date_range1"]').daterangepicker({
            //         opens: 'left'
            //     }, function(start, end, label) {
            //         console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
            //             ' to ' + end.format('YYYY-MM-DD'));
            //     });
            // });

            // //button export
            // $(document).on('click', '#submitexcel', function() {
            //     var date_range1 = $("#date_range1").val();
            //     var type_member = $("#type_member").val();
            //     var x = document.getElementById("submitexcel");
            //     x.disabled = true;
            //     var xhr = $.ajax({
            //         type: 'GET',
            //         url: "{{ route('members.exportexcel') }}",
            //         data: {
            //             "daterange1": date_range1,
            //             "type_member": type_member
            //         },
            //         cache: false,
            //         xhr: function() {
            //             var xhr = new XMLHttpRequest();
            //             xhr.onreadystatechange = function() {
            //                 if (xhr.readyState == 2) {
            //                     if (xhr.status == 200) {
            //                         xhr.responseType = "blob";
            //                     } else {
            //                         xhr.responseType = "text";
            //                     }
            //                 }
            //             };
            //             return xhr;
            //         },
            //         success: function(data) {
            //             const url = window.URL || window.webkitURL;
            //             const downloadURL = url.createObjectURL(data);
            //             var a = $("<a />");
            //             a.attr("download", 'Daftar Pesanan-' + type_member + '-Tanggal-' +
            //                 date_range1 + '.xlsx');
            //             a.attr("href", downloadURL);
            //             $("body").append(a);
            //             a[0].click();
            //             $("body").remove(a);
            //         }
            //     });
            // });

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
                tableAllMember.ajax.url(getFullUrl(data)).load(null, false);
            };

            init();

            function init() {
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }

            $('#select_city').autocomplete({
                'source': function(request, response) {
                    $.ajax({
                        url: urlAjaxCity + '?name=' + encodeURIComponent(request),
                        dataType: 'json',
                        success: function(json) {
                            response($.map(json, function(item) {
                                console.log(item)
                                return {
                                    label: item['text'] + ' ' + item['name'],
                                    value: item['id']
                                }
                            }));
                        }
                    });
                },
                'select': function(item) {
                    var cityName = item['label'].split(' ')
                    $('#select_city').val(cityName[1])
                }
            });
        });
    </script>
@endpush
