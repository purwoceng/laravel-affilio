@extends('core.app')
@section('title', __('Orders Page'))
@push('css')
    {{-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Orders</h5>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-omzet" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z" />
                            </svg>
                            Total Omzet Sebelum + Ongkir
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-omzet"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-supplier-price" class="card-title mb-5">0</h2>
                            <p class="card-subtitle mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box2-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4h-8.5ZM15 4.667V5H1v-.333L1.5 4h6V1h1v3h6l.5.667Z" />
                                </svg>
                                Harga Supplier
                            </p>
                            <small class="card-text text-muted">( <span id="js-date-range-supplier-price"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row ">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-omzet-ongkir" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1z" />
                            </svg>
                            Total Omzet + Ongkir
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-omzet-ongkir"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-bonus-profit" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-gem" viewBox="0 0 16 16">
                                <path
                                    d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z" />
                            </svg>
                            Total Keuntungan (Margin 100%)
                        </p>
                        <small class="card-text text-muted"> ( <span id="js-date-range-bonus-profit"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center my-2">
        <div class="row ">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-profit-keuntungan" class="card-title mb-5">0</h2>
                            <p class="card-subtitle mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>
                                Bonus Member (75%)
                            </p>
                            <br>
                            <small class="card-text text-muted">( <span id="js-date-range-profit-keuntungan"></span>
                                )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-profit-keuntungan-affilio" class="card-title mb-5">0</h2>
                            <p class="card-subtitle mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-award" viewBox="0 0 16 16">
                                    <path
                                        d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z" />
                                    <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z" />
                                </svg>
                                Keuntungan Affilio (24%)
                            </p>
                            <br>
                            <small class="card-text text-muted">( <span
                                    id="js-date-range-profit-keuntungan-affilio"></span>
                                )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-cadangan-kerugian-affilio" class="card-title mb-5">0</h2>
                            <p class="card-subtitle mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-building-dash" viewBox="0 0 16 16">
                                    <path
                                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1Z" />
                                    <path
                                        d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1V1Z" />
                                    <path
                                        d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
                                </svg>
                                Cadangan Rugi Payment Gateway (1%)
                            </p>
                            <small class="card-text text-muted">( <span
                                    id="js-date-range-cadangan-kerugian-affilio"></span>
                                )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-ongkir-60" class="card-title mb-5">0</h5>
                        <p class="card-subtitle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-ticket-fill" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13Z" />
                            </svg>
                            Ongkir 60%
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-ongkir-60"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-ongkir-30" class="card-title mb-5">0</h5>
                        <p class="card-subtitle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-ticket-detailed-fill" viewBox="0 0 16 16">
                                <path
                                    d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4 1a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5Zm0 5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5ZM4 8a1 1 0 0 0 1 1h6a1 1 0 1 0 0-2H5a1 1 0 0 0-1 1Z" />
                            </svg>
                            Ongkir 30%
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-ongkir-30"></span> )</small>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-ongkir-10" class="card-title mb-5">0</h5>
                        <p class="card-subtitle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-ticket-detailed" viewBox="0 0 16 16">
                                <path
                                    d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5ZM5 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                                <path
                                    d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z" />
                            </svg>
                            Ongkir 10%
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-ongkir-10"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-affiliasi-profit" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path
                                    d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            </svg>
                            Keuntungan Affiliasi Produk Member
                        </p>
                        <small class="card-text text-muted"> ( <span id="js-date-range-affiliasi-profit"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-service-fee" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bag-heart-fill" viewBox="0 0 16 16">
                                <path
                                    d="M11.5 4v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5ZM8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1Zm0 6.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z" />
                            </svg>
                            Biaya Layanan
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-service-fee"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-order" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-basket-fill" viewBox="0 0 16 16">
                                <path
                                    d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z" />
                            </svg>
                            Total Orders
                        </p>
                        <small class="card-text text-muted">( <span id="js-date-range-total-order"></span> )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-paid" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                            Sudah Bayar
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-paid"></span>
                            )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-cancel-but-unpaid" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bag-x-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM6.854 8.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293 6.854 8.146z" />
                            </svg>
                            Batal Belum Bayar
                        </p>
                        <small class="card-text text-muted">( <span
                                id="js-dashboard-total-persen-cancel-but-unpaid"></span> )</small>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-unpaid" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-clock-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                            </svg>
                            Belum Bayar
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-unpaid"></span>
                            )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-awaiting-supplier" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-shop" viewBox="0 0 16 16">
                                <path
                                    d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                            </svg>
                            Menunggu Seller
                        </p>
                        <small class="card-text text-muted">( <span
                                id="js-dashboard-total-persen-awaiting-supplier"></span> )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-process" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-shop-window" viewBox="0 0 16 16">
                                <path
                                    d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zm2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5z" />
                            </svg>
                            Proses Seller
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-process"></span>
                            )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-cancel" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-cart-x" viewBox="0 0 16 16">
                                <path
                                    d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z" />
                                <path
                                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                            Cancel
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-cancel"></span>
                            )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-shipping" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-truck" viewBox="0 0 16 16">
                                <path
                                    d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            </svg>
                            Dikirim
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-shipping"></span>
                            )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-received" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-house-check" viewBox="0 0 16 16">
                                <path
                                    d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708L7.293 1.5Z" />
                                <path
                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514Z" />
                            </svg>Sampai
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-received"></span>
                            )</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-success" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bag-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                <path
                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4

                                    H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                            </svg>
                            Sukses
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-success"></span>
                            )</small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container text-center my-2">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 id="js-dashboard-total-complain" class="card-title mb-5">0</h5>
                        <p class="card-subtitle mb-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-fire" viewBox="0 0 16 16">
                                <path
                                    d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                            </svg>
                            Komplain
                        </p>
                        <small class="card-text text-muted">( <span id="js-dashboard-total-persen-complain"></span>
                            )</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>


    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">List Orders</h3>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 mr">
                            <div class="form-group">
                                <label for="#" class="font-weight-bold">Pilih Status Order</label>
                                <select class="form-control form-control-sm filter" data-name="status"
                                    placeholder="Type Here">
                                    <option disabled>Pilih Status Order</option>
                                    <option value="all" selected>Semua</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                    <option value="process">Proses</option>
                                    <option value="shipping">Shipping</option>
                                    <option value="reject">Reject</option>
                                    <option value="cancel">Cancel</option>
                                    <option value="complaint">Complaint</option>
                                    <option value="received">Received</option>
                                    <option value="success">Success</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 mr">
                            <div class="form-group">
                                <label for="#" class="font-weight-bold">Pilih Baleo Status Order</label>
                                <select class="form-control form-control-sm filter" data-name="baleomol_status"
                                    placeholder="Type Here">
                                    <option disabled selected>Status Order</option>
                                    <option value="all">Semua</option>
                                    <option value="canceled">Canceled</option>
                                    <option value="canceled_but_unpaid">Cancel But Unpaid</option>
                                    <option value="confirm">Confirm</option>
                                    <option value="on_cancel_apply">On Cancel Apply</option>
                                    <option value="on_conpensation_apply">On Conpensation Apply</option>
                                    <option value="on_expedition">On Expedition</option>
                                    <option value="on_pickup">On Pickup</option>
                                    <option value="on_process">On Process</option>
                                    <option value="on_process_partner">On Process Partner</option>
                                    <option value="on_return_apply">On Return Apply</option>
                                    <option value="on_return_partner">On Return Partner</option>
                                    <option value="on_rueturn_shipping">On Return Shipping</option>
                                    <option value="on_rueturn_shipping_2">On Return Shipping2</option>
                                    <option value="on_shipping">On Shipping</option>
                                    <option value="on_shipping_partner">On Shipping Partner</option>
                                    <option value="on_shipping_resend_partial">On Shipping Resend Partial</option>
                                    <option value="over_sla">Over Sla</option>
                                    <option value="paid">Paid</option>
                                    <option value="pending_success">Pending Success</option>
                                    <option value="pickedup">Pickedup</option>
                                    <option value="recived">Recived</option>
                                    <option value="refund">Refund</option>
                                    <option value="request_pickup">Request Pickup</option>
                                    <option value="request_resi">Request Resi</option>
                                    <option value="resi_uploaded">Resi Uploaded</option>
                                    <option value="return_granted">Return Granted</option>
                                    <option value="returned">Returned</option>
                                    <option value="seller_return_confirm">Seller Return Confirm</option>
                                    <option value="success">Success</option>
                                    <option value="success_verified">Success Verified</option>
                                    <option value="success_with_cod_refund">Success With Cod Refund</option>
                                    <option value="success_with_complaint_partial_refund">Success With Complaint Partial
                                        Refund</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 ml-auto">
                            <div class="form-group">
                                <label for="js-daterange-picker" class="font-weight-bold">Pilih tanggal</label>
                                <div class='input-group' id='js-daterange-picker'>
                                    <input type='text' class="form-control filter" readonly="readonly"
                                        data-name="date_range" placeholder="Select date range" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="filter-wrapper">
                        <form action="#" class="form" id="filter">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="customer_name" placeholder="Nama Penerima" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="username" placeholder="Username Pembeli" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="resi" placeholder="Nomor Resi" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="code" placeholder="Kode Order" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="invoice_code" placeholder="Kode Invoice" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="baleo_order_code" placeholder="Kode Order Baleo" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm filter"
                                            data-name="phone" placeholder="Nomor Handphone" />
                                    </div>
                                </div>



                                {{-- <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <select class="form-control form-control-sm filter" data-name="status"
                                            placeholder="Type Here">
                                            <option disabled selected>Pilih Status Order</option>
                                            <option value="all">Semua</option>
                                            <option value="unpaid">Unpaid</option>
                                            <option value="paid">Paid</option>
                                            <option value="success">Success</option>
                                            <option value="cancel_unpaid">Cancel Unpaid</option>
                                            <option value="request_pickup">Riquest Pickup</option>
                                            <option value="shipping">On Shipping</option>
                                            <option value="on_return_shipping">On Return Shipping</option>
                                            <option value="on_return_apply">On Return Apply</option>
                                            <option value="received">Received</option>
                                            <option value="reject">Reject</option>
                                            <option value="claim_not_process">Claim Not Process</option>
                                            <option value="refund_disbursed">Refund Disbursed</option>
                                            <option value="disbursed">Disbursed</option>
                                        </select>
                                    </div>
                                </div> --}}

                            </div>
                        </form>
                    </div>


                    <div class="js-action mt-2 mb-4">
                        <div class="d-flex flex-row">
                            <div class="btn-group">
                                <div class="m-1">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success  excel"
                                        data-toggle="modal">
                                        <i class="fas fa-download fa-sm mr-1 excel"></i>@lang('Export Excel')
                                    </a>
                                </div>
                            </div>
                            <div class="btn-group">
                                <div class="m-1">
                                    <button class="btn btn-sm btn-primary shadow-sm" id="js-btn-sinkron-order" disabled><i
                                            class="fas fa-sync fa-sm text-white-50"></i> Sinkronkan Massal</button>
                                </div>
                            </div>

                            <div class="btn-group">
                                <div class="m-1">
                                    <button class="btn btn-sm btn-warning shadow-sm text-white"
                                        id="js-btn-checkout-voucher" disabled><i
                                            class="fas fa-tag fa-sm text-white-50"></i> Checkout Massal Pesanan</button>
                                </div>
                            </div>
                            <div class="btn-group">
                                <div class="m-1">
                                    <button class="btn btn-sm btn-danger shadow-sm text-white" id="js-btn-resi"
                                        disabled><i class="fas fa-print fa-sm text-white-50"></i> Buat Resi
                                        Pesanan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="js-orders-table"
                        class="table table-bordered table-hover table-head-custom table-checkable nowrap">
                        <thead class="thead-secondary">
                            <tr class="small">
                                <th class="text-center" width="10%">#</th>
                                <th class="text-center" width="10%">Order Code</th>
                                <th class="text-center" width="10%">Invoice Code</th>
                                <th class="text-center" width="10%">Baleo Order Code</th>
                                <th class="text-center" width="10%">Username</th>
                                <th class="text-center" width="10%">Nama Penerima</th>
                                <th class="text-center" width="10%">Nomor Resi</th>
                                <th class="text-center" width="10%">Ongkir</th>
                                <th class="text-center" width="10%">Fee</th>
                                <th class="text-center" width="10%">Harga</th>
                                <th class="text-center" width="10%">Subtotal</th>
                                <th class="text-center" width="10%">Total</th>
                                <th class="text-center" width="10%">Nomor HP</th>
                                <th class="text-center" width="10%">Alamat</th>
                                <th class="text-center" width="10%">Baleomol Status</th>
                                <th class="text-center" width="10%">Status</th>
                                <th class="text-center" width="10%">Kurir</th>
                                <th class="text-center" width="10%">Tanggal Pemesanan</th>
                                <th scope="col" class="text-center" width="5%">Terakhir Disinkronkan</th>
                                <th scope="col" class="text-center" width="5%">Checklist <input type="checkbox"
                                        value="" id="checkAll" class="pt-2"></th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    @include('orders.partials.modal')
@endsection


@push('js')
    {{-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/helpers/order-helper.js') }}"></script>
    <script>
        'use strict';


        $(document).ready(function() {
            const ajaxUrl = "{{ route('orders.index') }}";

            var ordersTable = $('#js-orders-table').DataTable({
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
                    [50, 100, 200, 300, 400, 500],
                    [50, 100, 200, 300, 400, 500, ]
                ],
                pageLength: 50,
                order: [
                    [0, 'DESC']
                ],
                ajax: {
                    url: ajaxUrl,
                    type: 'GET',
                },
                scrollX: true,
                columns: [{
                        data: null,
                        sortable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            const index = meta.row + meta.settings._iDisplayStart + 1;
                            return index;
                        }
                    },
                    {
                        data: 'code',
                        name: 'code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'invoice_code',
                        name: 'invoice_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'baleo_order_code',
                        name: 'baleo_order_code',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'username',
                        name: 'username',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'resi',
                        name: 'resi',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'shipping_cost',
                        name: 'shipping_cost',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'fee',
                        name: 'fee',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'affilio_subtotal',
                        name: 'affilio_subtotal',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'subtotal',
                        name: 'subtotal',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'total',
                        name: 'total',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'address',
                        name: 'address',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'baleomol_status',
                        name: 'baleomol_status',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row) {
                            return statusDescription(row.baleomol_status);
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row) {
                            return statusDescription(row.status);
                        }
                    },
                    {
                        data: 'courier',
                        name: 'courier',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-left small',
                    },
                    {
                        data: 'date_created',
                        name: 'date_created',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                    },
                    {
                        data: 'last_synced_elapsed',
                        name: 'last_synced_elapsed',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row) {
                            let elements =
                                `<div class="d-block small"><span class="small">${row.last_synced_elapsed}</span></div>`;

                            if (row.last_synced_stamp >= 900 && !['unpaid'].includes(row
                                    .baleomol_status)) {
                                elements += `<div class="d-block mt-2">
                                    <button class="btn btn-sm btn-primary px-3 js-sync-order-btn"
                                        data-id="${row.id}"><small>Sinkronkan</small></button>
                                </div>`;
                            }

                            return elements;
                        }
                    },
                    {
                        data: 'checkbox',
                        className: 'text-center small',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            let elements = ``;
                            if (row.last_synced_stamp >= 900 && !['unpaid'].includes(row
                                    .baleomol_status)) {
                                elements =
                                    `<input type="checkbox" name="orders[]" class="js-syncron-order"  value="${row.id}" data-id="${row.id}" data-customer="${row.name}" data-date_created="${row.date_created}" data-whatsapp="${row.phone}">`;
                            }
                            if (row.status == 'paid' && row.payment_status == 'paid' && row
                                .baleomol_status == 'unpaid') {
                                elements =
                                    `<input type="checkbox" name="orders[]" class="js-checkout-order"  value="${row.id}" data-id="${row.id}" data-customer="${row.name}" data-date_created="${row.date_created}" data-whatsapp="${row.phone}">`;
                            }
                            return elements;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        orderable: false,
                        searchable: false,
                        className: 'text-center small',
                        render: function(data, type, row, meta) {
                            let elements = '';
                            let checkoutButton = '';

                            if (row.baleomol_status === 'unpaid' && row.status === 'paid' && row
                                .payment_status === 'paid') {
                                checkoutButton +=
                                    `<hr/ class="m-1"><a class="nav-link js-checkout-item-order" href="javascript:void(0)" data-id="${row.id}">Checkout Pesanan</span></a>`;
                            }

                            elements += `<div class="dropdown dropdown-inline">
                                <a href="javascript:void(0)"
                                    class="btn btn-sm btn-primary btn-icon"
                                    data-toggle="dropdown">
                                    <i class="la la-cog"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <ul class="nav nav-hoverable flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link js-detail-order" href="javascript:void(0)" data-toggle="modal" data-id="${row.id}">Detail
                                            </a>
                                            <a class="nav-link js-detail-order" href="javascript:void(0)" data-toggle="modal" data-id="${row.id}">Sukseskan
                                            </a>
                                            ${checkoutButton}
                                        </li>
                                    </ul>
                                </div>
                            </div>`;

                            return elements;
                        },
                    }
                ]
            });

            init();

            function init() {
                getDateRangeHandler();
                $(document).on('keyup clear change', '.filter', delay(getDataFiltered, 1000));
            }

            function getDateRangeHandler() {
                $('#js-daterange-picker').daterangepicker({
                    timePickerSeconds: true,
                    showDropdwons: true,
                    autoApply: true,
                    ranges: {
                        'Semua': [moment(new Date('01-01-2021')), moment()],
                        'Hari Ini': [moment(), moment()],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    },
                    locale: {
                        format: 'YYYY-MM-DD',
                        separator: " to ",
                        applyLabel: "Apply",
                        cancelLabel: "Cancel",
                        fromLabel: "From",
                        toLabel: "To",
                        customRangeLabel: "Custom Range",
                        weekLabel: "W",
                        daysOfWeek: [
                            "Su",
                            "Mo",
                            "Tu",
                            "We",
                            "Th",
                            "Fr",
                            "Sa"
                        ],
                        monthNames: [
                            "Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "October",
                            "November",
                            "December"
                        ],
                        firstDay: 1
                    },
                    autoUpdateInput: false,
                    alwaysShowCalendars: false,
                    startDate: moment(),
                    endDate: moment(),
                }, rangePickerCB);
                rangePickerCB(moment(), moment());
                let data = [];
                data.push(moment().format('YYYY-MM-DD'));
                data.push(moment().format('YYYY-MM-DD'));
            }

            function rangePickerCB(start, end, label) {
                $('#js-daterange-picker').find('.form-control').val(start.format('YYYY-MM-DD') + '/' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-omzet').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-omzet-ongkir').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-supplier-price').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-bonus-profit').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-affiliasi-profit').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-profit-keuntungan').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-profit-keuntungan-affilio').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-cadangan-kerugian-affilio').html(start.format('YYYY-MM-DD') + ' / ' + end.format(
                    'YYYY-MM-DD'));
                $('#js-date-range-ongkir-60').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-ongkir-30').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-ongkir-10').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-unique-code').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-service-fee').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                $('#js-date-range-total-order').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
                getDataFiltered();

            };

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
                dashboardHandler(data);
                reDrawTable(data);
            };

            function getFullUrl(data) {
                let
                    url = ajaxUrl,
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
                ordersTable.ajax.url(getFullUrl(data)).load(null, false);
            };

            function dashboardHandler(data) {
                let dateRangeVal = data.date_range;
                let dataSplit = dateRangeVal.split("/");
                let startDate = dataSplit[0];
                let endDate = dataSplit[1];
                let status = data.status;

                let url = "{{ URL::to('/') }}" + `/orders/get-dashboard`;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        status: status,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {

                            mappingDashboard(response.data);
                        } else {
                            Swal.fire({
                                title: response.errors.title,
                                html: response.errors.messages,
                                icon: response.errors.icon,
                            })
                        }

                    },
                });
            }

            let totalOmzetAll = $('#js-dashboard-total-omzet');
            let totalOmzetOngkir = $('#js-dashboard-total-omzet-ongkir');
            let totalSupplierPrice = $('#js-dashboard-supplier-price');
            let bonusProfit = $('#js-dashboard-bonus-profit');
            let AffiliasiProfit = $('#js-dashboard-affiliasi-profit');
            let profitKeuntungan = $('#js-dashboard-profit-keuntungan');
            let profitKeuntunganAffilio = $('#js-dashboard-profit-keuntungan-affilio');
            let cadanganKerugianAffilio = $('#js-dashboard-cadangan-kerugian-affilio');
            let ongkir60 = $('#js-dashboard-ongkir-60');
            let ongkir30 = $('#js-dashboard-ongkir-30');
            let ongkir10 = $('#js-dashboard-ongkir-10');
            let uniqueCode = $('#js-dashboard-unique-code');
            let serviceFee = $('#js-dashboard-service-fee');
            let totalOrder = $('#js-dashboard-total-order');

            let totalPaid = $('#js-dashboard-total-paid');
            let totalPersenPaid = $('#js-dashboard-total-persen-paid');

            let totalCancelButUnpaid = $('#js-dashboard-total-cancel-but-unpaid');
            let totalPersenCancelButUnpaid = $('#js-dashboard-total-persen-cancel-but-unpaid');

            let totalUnpaid = $('#js-dashboard-total-unpaid');
            let totalPersenUnpaid = $('#js-dashboard-total-persen-unpaid');

            let totalAwaitingSupplier = $('#js-dashboard-total-awaiting-supplier');
            let totalPersenAwaitingSupplier = $('#js-dashboard-total-persen-awaiting-supplier');

            let totalProcess = $('#js-dashboard-total-process');
            let totalPersenProcess = $('#js-dashboard-total-persen-process');

            let totalCancel = $('#js-dashboard-total-cancel');
            let totalPersenCancel = $('#js-dashboard-total-persen-cancel');

            let totalShipping = $('#js-dashboard-total-shipping');
            let totalPersenShipping = $('#js-dashboard-total-persen-shipping');

            let totalReceived = $('#js-dashboard-total-received');
            let totalPersenReceived = $('#js-dashboard-total-persen-received');

            let totalSuccess = $('#js-dashboard-total-success');
            let totalPersenSuccess = $('#js-dashboard-total-persen-success');

            let totalComplain = $('#js-dashboard-total-complain');
            let totalPersenComplain = $('#js-dashboard-total-persen-complain');

            function mappingDashboard(data) {
                totalOmzetAll.html(data.total_omzet);
                totalOmzetOngkir.html(data.total_omzet_ongkir);
                totalSupplierPrice.html(data.supplier_price);
                bonusProfit.html(data.bonus_profit);
                AffiliasiProfit.html(data.Affiliasi_profit);
                profitKeuntungan.html(data.profit_keuntungan);
                profitKeuntunganAffilio.html(data.profit_keuntungan_affilio);
                cadanganKerugianAffilio.html(data.cadangan_kerugian_affilio);
                ongkir60.html(data.total_ongkir_60);
                ongkir30.html(data.total_ongkir_30);
                ongkir10.html(data.total_ongkir_10);
                uniqueCode.html(data.unique_code);
                serviceFee.html(data.service_fee);
                totalOrder.html(data.total_order);

                totalPaid.html(data.total_paid);
                totalPersenPaid.html(data.total_persen_paid);

                totalCancelButUnpaid.html(data.total_cancel_but_unpaid);
                totalPersenCancelButUnpaid.html(data.total_persen_cancel_but_unpaid);

                totalUnpaid.html(data.total_unpaid);
                totalPersenUnpaid.html(data.total_persen_unpaid);

                totalAwaitingSupplier.html(data.total_awaiting_supplier);
                totalPersenAwaitingSupplier.html(data.total_persen_awaiting_supplier);

                totalProcess.html(data.total_process);
                totalPersenProcess.html(data.total_persen_process);

                totalCancel.html(data.total_cancel);
                totalPersenCancel.html(data.total_persen_cancel);

                totalShipping.html(data.total_shipping);
                totalPersenShipping.html(data.total_persen_shipping);

                totalReceived.html(data.total_received);
                totalPersenReceived.html(data.total_persen_received);

                totalSuccess.html(data.total_success);
                totalPersenSuccess.html(data.total_persen_success);

                totalComplain.html(data.total_complain);
                totalPersenComplain.html(data.total_persen_complain);
            };

            //exportexcel
            let excelModal = $('#js-detail-modal');
            $(document).on("click", ".excel", function(e) {
                let elementHTML = `
                    <div class="form-group row">
                        <label for="js-daterange-picker1" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <div class='input-group' id='js-daterange-picker'>
                                    <input type='text' class="form-control filter"
                                            id="date_range1" name="date_range1" placeholder="Select date range" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                </div>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status Pesanan</label>
                        <div class="col-sm-10">
                            <select class="form-control form-control-sm filter" data-name="status1" id="status1"
                                                placeholder="Type Here">
                                                <option disabled >Pilih Status Order</option>
                                                <option value="all" selected>Semua</option>
                                                <option value="unpaid">Unpaid</option>
                                                <option value="paid">Paid</option>
                                                <option value="process">Proses</option>
                                                <option value="shipping">Shipping</option>
                                                <option value="reject">Reject</option>
                                                <option value="cancel">Cancel</option>
                                                <option value="complaint">Complaint</option>
                                                <option value="received">Received</option>
                                                <option value="success">Success</option>
                                            </select>
                        </div>
                    </div>


                `;


                let elementFooter = `
                            <button type="submit" class="btn btn-light-success font-weight-bold" id="submitexcel">Export</button>
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button> </form>
                            `;

                excelModal.find(".modal-title").html('Input Export Excel');
                excelModal.find(".modal-body").html(elementHTML);
                excelModal.find(".modal-footer").html(elementFooter);
                excelModal.modal('show');

            });

            // Detail Order
            let orderModal = $('#js-detail-modal');
            $(document).on("click", ".js-detail-order", function(e) {
                let orderId = $(e.target).data('id');
                let url = ajaxUrl + '/show/' + orderId;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            let data = response.data;
                            var dataObj = response.data.orderProducts;
                            let productName = '';
                            let productInformation = '';

                            productInformation += `
                                    <table class="table table-striped my-3">
                                    <thead>
                                            <tr class="text-center">
                                                <th scope="col">Nama Produk</th>
                                                <th scope="col">Nama Variant</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Harga Jual</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                            for (const key in dataObj) {
                                productInformation += ` <tr>
                                                <td class="text-center small">${dataObj[key].product_name}</td>
                                                <td class="text-center small">${dataObj[key].variant_name}</td>
                                                <td class="text-center small">${dataObj[key].amount}</td>
                                                <td class="text-center small">${dataObj[key].price}</td>
                                            </tr>`;
                            }

                            productInformation += `</tbody>
                                    </table>`;

                            let elementHTML = `
                                    <div class="container-fluid">
                                        <div class="d-flex justify-content-end">
                                            <div class="d-flex flex-column">
                                                <div class="p-1">
                                                    <h4 class="mb-0 font-weight-bold text-right">INVOICE #${data.order.invoice_code ? data.order.invoice_code :'-'}</h4>
                                                </div>
                                                <small class="p-1 text-right">Tanggal Pesanan : ${data.order.date_created} </small>
                                            </div>
                                        </div>
                                        <div class="justify-content">
                                            <div class="d-flex">
                                                <div class="p-0 h6"><b></b></div>
                                                <div class="ml-auto px-2"> Status :<span class="p-2">${data.order.status}</span> </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="p-1"><b>Nama : </b>${data.order.customer_name}</div>
                                            <div class="p-1 ml-3"><b>Phone : </b>${data.order.phone}</div>
                                            <div class="p-1 ml-3"><b>Alamat : </b>${data.order.address}</div>
                                            <div class="p-1 ml-3"><b>Kota Tujuan : </b> ${data.order.full_address}</div>
                                            <div class="p-1 ml-3"><b>Kode Pos : </b>${data.order.zip_code}</div>
                                            <div class="p-1 "><b>Nomor Resi : </b>${data.order.resi}</div>
                                            <div class="p-1 "><b>Catatan : </b>${data.order.message}</div>
                                        </div>

                                        <div class="justify-content mt-4">
                                            <div class="d-flex">
                                                <div class="p-0 h6"><b>Rincian Pesanan :</b></div>
                                                <div class="ml-auto p-0"><b>Harga</b></div>
                                            </div>
                                        </div>
                                        <hr class="m-1">

                                        <div class="justify-content mt-3">
                                            <div class="d-flex">
                                                <div class="p-0 flex-column">
                                                    <div class="p-1"><b>Nama Produk :</b> ${data.orderProducts[0].product_name}</div>
                                                </div>
                                            </div>

                                            <div class="d-flex"> ${productInformation}</div>

                                            <div class="d-flex">
                                            <div class="p-1"></div>
                                                <div class="ml-auto p-1">
                                                    <div class="p-1"><b>${data.order.value}</b></div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="m-1">
                                        <div class="justify-content mt-1">
                                            <div class="d-flex">
                                                <div class="p-1">Shipping Fee <span class="text-uppercase">${data.order.shipping_courier} - ${data.order.shipping_service}</span></div>
                                                <div class="ml-auto p-1"><b>${data.order.shipping_cost}</b></div>
                                            </div>
                                        </div>

                                        <div class="justify-content mt-4 mb-2">
                                            <hr class="m-1">
                                            <div class="d-flex">
                                                <div class="p-1"><b>TOTAL</b></div>
                                                <div class="ml-auto p-1"><b>${data.order.total}</b></div>
                                            </div>
                                        </div>
                                    </div>`;

                            let elementFooter = `
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                            `;
                            orderModal.find(".modal-title").html('Detail Order');
                            orderModal.find(".modal-body").html(elementHTML);
                            orderModal.find(".modal-footer").html(elementFooter);
                            orderModal.modal('show');
                        }
                    }
                });
            });

            // Checkout To Baleomol.com
            $(document).on("click", ".js-checkout-item-order", function(e) {
                let orderId = $(e.target).data('id');
                Swal.fire({
                        title: 'Meneruskan Pesanan ke Baleomol.com',
                        html: `Anda yakin ingin checkout meneruskan pesanan ini?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#bfbfbf',
                        confirmButtonText: 'Ya, teruskan pesanan!',
                        cancelButtonText: 'Batal',
                    })
                    .then(function(result) {
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
                                let urlGetOrder = "{{ route('orders.getOrder') }}";
                                $.ajax({
                                    type: "GET",
                                    url: urlGetOrder,
                                    data: {
                                        order_data: [{
                                            'order_id': orderId
                                        }],
                                    },
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            const postOptions = {
                                                method: 'POST',
                                                headers: {
                                                    Authorization: 'Bearer ' +
                                                        `{{ config('app.baleomol_token_auth') }}`,
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({
                                                    'orderData': response
                                                        .data,
                                                }),
                                            };
                                            fetch(`{{ config('app.baleomol_url') . '/checkout-partnership' }}`,
                                                    postOptions)
                                                .then(function(res) {
                                                    return res.json();
                                                })
                                                .then(function(data) {
                                                    if (data.success) {
                                                        let invoiceId = data
                                                            .data.invoiceId;
                                                        let invoiceCode = data
                                                            .data.invoiceCode;
                                                        let invoiceTotal = data
                                                            .data.invoiceTotal;
                                                        let orderDatas = [];
                                                        let results = [];

                                                        for (let i = 0; i < data
                                                            .data.orderData
                                                            .length; i++) {
                                                            let orderId = data
                                                                .data.orderData[
                                                                    i]
                                                                .partnershipOrderId;
                                                            results += JSON
                                                                .stringify([{
                                                                    'order_id': data
                                                                        .data
                                                                        .orderData[
                                                                            i
                                                                        ]
                                                                        .orderId,
                                                                    'order_code': data
                                                                        .data
                                                                        .orderData[
                                                                            i
                                                                        ]
                                                                        .orderCode,
                                                                    'partnership_order_id': data
                                                                        .data
                                                                        .orderData[
                                                                            i
                                                                        ]
                                                                        .partnershipOrderId,
                                                                    'products': data
                                                                        .data
                                                                        .orderData[
                                                                            i
                                                                        ]
                                                                        .products,
                                                                }]);
                                                        }

                                                        $.ajax({
                                                                type: "POST",
                                                                url: `{{ route('orders.updateOrder') }}`,
                                                                data: {
                                                                    _token: "{{ csrf_token() }}",
                                                                    invoice_id: invoiceId,
                                                                    invoice_code: invoiceCode,
                                                                    invoice_total: invoiceTotal,
                                                                    order_data: results,
                                                                },
                                                                success: function(
                                                                    response
                                                                ) {
                                                                    Swal.fire({
                                                                        title: response
                                                                            .title,
                                                                        html: response
                                                                            .message,
                                                                        icon: response
                                                                            .icon,
                                                                    });
                                                                }
                                                            })
                                                            .then(function() {
                                                                $(this)
                                                                    .addClass(
                                                                        'btn-disabled'
                                                                    );
                                                                getDataFiltered
                                                                    ();
                                                            });

                                                    } else {
                                                        let messages = '';
                                                        messages += '<ul>';
                                                        for (let i = 0; i < data
                                                            .data.length; i++) {
                                                            for (let j = 0; j <
                                                                data.data[i]
                                                                .products[0]
                                                                .errors
                                                                .length; j++) {
                                                                messages +=
                                                                    '<li style="text-align: left;">' +
                                                                    data.data[i]
                                                                    .products[0]
                                                                    .errors[j] +
                                                                    '</li>';
                                                            }
                                                        }
                                                        messages += '</ul>';
                                                        Swal.fire({
                                                            title: data
                                                                .message,
                                                            html: '<span style="text-align: left; display:block;">Pesanan gagal diteruskan di Baleomol.com, dengan rincian : </span><br>' +
                                                                messages,
                                                            icon: 'error',
                                                        });

                                                    }
                                                }, function(err) {
                                                    const error = err.errors ||
                                                    {};
                                                    const errorTitle = error
                                                        .title ||
                                                        'Gagal Checkout Pesanan';
                                                    const errorMessage = error
                                                        .title ||
                                                        'Maaf terjadi kesalahan saat checkout data pesanan Anda!';

                                                    Swal.fire(
                                                        errorTitle,
                                                        errorMessage,
                                                        'warning'
                                                    );
                                                    $(this).removeClass(
                                                        'btn-disabled');
                                                })
                                                .catch((error) => {
                                                    console.log({
                                                        error
                                                    })
                                                });



                                        } else {
                                            Swal.fire(
                                                response.errors.title || '',
                                                response.errors.message || '',
                                                'warning',
                                            );

                                            $(this).removeClass('btn-disabled');
                                        }
                                    },
                                    error: (function(err) {
                                        Swal.fire(
                                            'Terjadi Kesalahan',
                                            'Kami tidak bisa menemukan data pesanan Anda, mohon coba kembali beberapa saat lagi!',
                                            'warning',
                                        );
                                        $(this).removeClass('btn-disabled');
                                    })
                                });

                            }, 500);
                        } else {
                            console.log('false');
                            $(this).removeClass('btn-disabled');
                            $(`.js-checkout-hutang[data-id="${id}"]`).removeClass('btn-disabled');
                        }
                    });
            });


            // Checkbox Orderan
            const checkAll = $("#checkAll");
            const checkboxsingle = $('input:checkbox');
            const sinkronMasalBtn = $('#js-btn-sinkron-order');
            const checkoutVoucherBtn = $('#js-btn-checkout-voucher');
            const ResiBtn = $('#js-btn-resi');

            checkAll.click(function() {
                if (!$(this).is(':checked')) {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                    checkoutVoucherBtn.prop('disabled', true);
                    ResiBtn.prop('disabled', true);
                } else {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                }
            });

            //function checkBox single
            $(document).on('click', 'input:checkbox', function(e) {
                if (!$(this).is(':checked')) {
                    $('#checkAll').prop('checked', false);
                    // sinkronMasalBtn.prop('disabled', true);
                    checkoutVoucherBtn.prop('disabled', true);
                    ResiBtn.prop('disabled', true);
                } else {
                    // sinkronMasalBtn.prop('disabled', false);
                    checkoutVoucherBtn.prop('disabled', false);
                    ResiBtn.prop('disabled', false);
                }
            });

            //BULK CHECKOUT VOUCHER MASAL
            checkoutVoucherBtn.click((e) => {
                const ordersId = [];
                const checkOut = $('.js-checkout-order:checked');
                const syncronChecked = $('.js-syncron-order:checked');
                const checked = $('.orders:checked');
                const finalChecked = [...checkOut];
                const totalChecked = [...checked, ...checkOut];
                if (finalChecked.length >= 1) {
                    $.each(finalChecked, function(i, item) {
                        ordersId.push({
                            'order_id': $(item).val()
                        });
                    });

                    Swal.fire({
                        showCloseButton: false,
                        showConfirmButton: false,
                        icon: 'info',
                        title: 'Harap Tunggu',
                        html: 'Total ada <b>' + finalChecked.length +
                            '</b> pesanan, Sedang meneruskan pesanan massal anda ke baleomol.com',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        onBeforeOpen: function() {
                            Swal.showLoading();
                        },
                    });

                    setTimeout(function() {
                        let urlGetOrder = "{{ route('orders.getOrder') }}";
                        $.ajax({
                            type: "GET",
                            url: urlGetOrder,
                            data: {
                                order_data: ordersId,
                            },
                            success: function(response) {

                                if (response.status === 'success') {
                                    const postOptions = {
                                        method: 'POST',
                                        headers: {
                                            Authorization: 'Bearer ' +
                                                `{{ config('app.baleomol_token_auth') }}`,
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            'orderData': response.data,
                                        }),
                                    };
                                    fetch(`{{ config('app.baleomol_url') . '/checkout-partnership' }}`,
                                            postOptions)
                                        .then(function(res) {
                                            return res.json();
                                        })
                                        .then(function(data) {
                                            if (data.success) {
                                                let invoiceId = data.data.invoiceId;
                                                let invoiceCode = data.data
                                                    .invoiceCode;
                                                let invoiceTotal = data.data
                                                    .invoiceTotal;
                                                let orderDatas = [];
                                                let results = [];

                                                for (let i = 0; i < data.data
                                                    .orderData.length; i++) {
                                                    let orderId = data.data
                                                        .orderData[i]
                                                        .partnershipOrderId;
                                                    results.push({
                                                        'order_id': data
                                                            .data
                                                            .orderData[
                                                                i]
                                                            .orderId,
                                                        'order_code': data
                                                            .data
                                                            .orderData[
                                                                i]
                                                            .orderCode,
                                                        'partnership_order_id': data
                                                            .data
                                                            .orderData[
                                                                i]
                                                            .partnershipOrderId,
                                                        'products': data
                                                            .data
                                                            .orderData[
                                                                i]
                                                            .products,
                                                    })
                                                    // results += JSON.stringify([{
                                                    //     'order_id': data
                                                    //         .data
                                                    //         .orderData[
                                                    //             i]
                                                    //         .orderId,
                                                    //     'order_code': data
                                                    //         .data
                                                    //         .orderData[
                                                    //             i]
                                                    //         .orderCode,
                                                    //     'partnership_order_id': data
                                                    //         .data
                                                    //         .orderData[
                                                    //             i]
                                                    //         .partnershipOrderId,
                                                    //     'products': data
                                                    //         .data
                                                    //         .orderData[
                                                    //             i]
                                                    //         .products,
                                                    // }]);
                                                }

                                                $.ajax({
                                                        type: "POST",
                                                        url: `{{ route('orders.updateOrder') }}`,
                                                        data: {
                                                            _token: "{{ csrf_token() }}",
                                                            invoice_id: invoiceId,
                                                            invoice_code: invoiceCode,
                                                            invoice_total: invoiceTotal,
                                                            order_data: JSON
                                                                .stringify(
                                                                    results),
                                                        },
                                                        success: function(
                                                            response) {
                                                            Swal.fire({
                                                                title: response
                                                                    .title,
                                                                html: response
                                                                    .message,
                                                                icon: response
                                                                    .icon,
                                                            });
                                                        }
                                                    })
                                                    .then(function() {
                                                        $(this).addClass(
                                                            'btn-disabled');
                                                        getDataFiltered();
                                                    });

                                            } else {
                                                let messages = '';
                                                if (data.data === undefined || data
                                                    .data == null || data.data
                                                    .length <= 0) {
                                                    Swal.fire({
                                                        title: data.message,
                                                        html: 'Mohon maaf anda tidak dapat melakukan checkout pesanan dikarenakan </br> Vocuher anda <b>"Tidak Cukup"</b>',
                                                        icon: 'error',
                                                    });
                                                } else {
                                                    messages += '<ul>';
                                                    for (let i = 0; i < data.data
                                                        .length; i++) {
                                                        for (let j = 0; j < data
                                                            .data[i].products[0]
                                                            .errors.length; j++) {
                                                            messages +=
                                                                '<li style="text-align: left;">' +
                                                                data.data[i]
                                                                .products[0].errors[
                                                                    j] + '</li>';
                                                        }

                                                    }
                                                    messages += '</ul>';
                                                    Swal.fire({
                                                        title: data.message,
                                                        html: '<span style="text-align: left; display:block;">Pesanan gagal diteruskan di Baleomol.com, dengan rincian : </span><br>' +
                                                            messages,
                                                        icon: 'error',
                                                    });
                                                }
                                            }
                                        }, function(err) {
                                            const error = err.errors || {};
                                            const errorTitle = error.title ||
                                                'Gagal Checkout Pesanan';
                                            const errorMessage = error.title ||
                                                'Maaf terjadi kesalahan saat checkout data pesanan Anda!';

                                            Swal.fire(
                                                errorTitle,
                                                errorMessage,
                                                'warning'
                                            );
                                            $(this).removeClass('btn-disabled');
                                        })
                                        .catch((error) => {
                                            console.log({
                                                error
                                            })
                                        });



                                } else {
                                    Swal.fire(
                                        response.errors.title || '',
                                        response.errors.message || '',
                                        'warning',
                                    );

                                    $(this).removeClass('btn-disabled');
                                }
                            },
                            error: (function(err) {
                                Swal.fire(
                                    'Terjadi Kesalahan',
                                    'Kami tidak bisa menemukan data pesanan Anda, mohon coba kembali beberapa saat lagi!',
                                    'warning',
                                );
                                $(this).removeClass('btn-disabled');
                            })
                        });

                    }, 500);


                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: `Orderan Belum Dipilih`,
                        text: `mohon coba kembali`
                    })
                }
            });




            // sinkronMasalBtn.click((e) => {
            //     const ordersId = [];
            //     const deleteChecked = $('.js-orders-delete:checked');
            //     const deleteReject = $('.js-reject:checked');
            //     const checkOut = $('.js-checkout-order:checked');
            //     const notCompleteChecked = $('.js-order-not-complete:checked');
            //     const checked = $('.orders:checked');
            //     const finalChecked = [...checked, ...deleteReject];
            //     const totalChecked = [...deleteChecked, ...checked, ...deleteReject, ...checkOut, ...
            //         notCompleteChecked
            //     ];
            //     if (finalChecked.length >= 1) {
            //         $.each(finalChecked, function(i, item) {
            //             ordersId.push($(item).val());
            //         });
            //         syncronMultipleHandler(ordersId, totalChecked);
            //     } else if ($('input[type=checkbox]').hasClass("orders") == true || ('input[type=checkbox]')
            //         .hasClass("js-order-not-complete") == true) {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: `Sinkron tidak tersedia untuk orderan ini`,
            //             text: `Silahkan checkout order atau periksa status orderan`
            //         });
            //     } else {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: `Orderan Belum Dipilih`,
            //             text: `mohon coba kembali`
            //         });
            //     }
            // });

            // async function syncronMultipleHandler(ordersId, totalChecked) {
            //     try {
            //         const processed = [];
            //         const totalProses = totalChecked.length;
            //         const totalOrderid = ordersId.length;
            //         const orders = [...ordersId];
            //         let success = 0;
            //         let failed = 0;

            //         async function recursive() {
            //             if (processed.length != ordersId.length) {
            //                 const orderId = orders.pop();
            //                 processed.push(orderId);
            //                 Swal.fire({
            //                     icon: 'info',
            //                     title: `Sedang memproses permintaan, Mohon jangan berpindah halaman`,
            //                     animation: false,
            //                     text: `Memproses ${processed.length} dari ${totalProses} pesanan. ${success} Berhasil.`,
            //                     allowOutsideClick: false,
            //                     showConfirmButton: false,
            //                     onRender: function() {
            //                         Swal.showLoading();
            //                     }
            //                 });
            //                 const response = await singleSyncronHandler(orderId);
            //                 response.success ? success++ : failed++;
            //                 await recursive();
            //             } else {
            //                 Swal.close();
            //                 if (totalProses != totalOrderid) {
            //                     errorStatus = totalProses - totalOrderid;
            //                     for (i = 0; i < errorStatus; i++) {
            //                         failed++
            //                     }
            //                 }
            //                 Swal.fire({
            //                     icon: success > 0 ? 'success' : 'error',
            //                     title: `${success} Pesanan berhasil disinkronkan. ${failed} Pesanan gagal disinkronkan.`,
            //                     html: `Silahkan cek status pesanan Anda. ${failed > 0 ? `<p style="color:red;">Pastikan kembali pesanan anda</p>` : ''}`,
            //                     showConfirmButton: true
            //                 }).then(function() {
            //                     $('#checkAll').prop('checked', false);
            //                     sinkronMasalBtn.prop('disabled', true);
            //                     deleteMasalBtn.prop('disabled', true);
            //                     checkoutHutangBtn.prop('disabled', true);
            //                     checkoutVoucherBtn.prop('disabled', true);
            //                     getDataFiltered();
            //                     // location.reload();
            //                 });
            //             }
            //         }
            //         await recursive();
            //     } catch (error) {
            //         Swal.fire({
            //             icon: 'warning',
            //             title: `Kami mengalami kendala`,
            //             text: `mohon coba kembali`
            //         })
            //     }
            // }

            // async function singleSyncronHandler(orderId) {
            //     return new Promise(async (resolve, reject) => {
            //         try {
            //             const ajaxPath = '{{ url('/api/sync-order') }}';
            //             const order_id = orderId;

            //             let options = {
            //                 headers: {
            //                     'Content-Type': 'application/json'
            //                 }
            //             };
            //             options.method = 'POST';
            //             options.body = JSON.stringify({
            //                 order_id
            //             });

            //             const response = await fetch(ajaxPath, options);
            //             const resp = await response.json();
            //             if (response.status == 200) {
            //                 if (resp.status == "success") {
            //                     resolve({
            //                         success: true,
            //                         data: resp.data
            //                     });
            //                 } else {
            //                     resolve({
            //                         success: false,
            //                         data: resp.error
            //                     });
            //                 }
            //             } else {
            //                 resolve({
            //                     success: false,
            //                     data: resp
            //                 });
            //             }

            //         } catch (error) {
            //             reject({
            //                 success: false,
            //                 data: error
            //             });
            //         }
            //     });
            // }

            //js datepicker excel
            $('#js-detail-modal').on('shown.bs.modal', function(e) {
                $('input[name="date_range1"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
                        ' to ' + end.format('YYYY-MM-DD'));
                });
            });

            //button export
            $(document).on('click', '#submitexcel', function() {
                var date_range1 = $("#date_range1").val();
                var status1 = $("#status1").val();
                var x = document.getElementById("submitexcel");
                x.disabled = true;
                var xhr = $.ajax({
                    type: 'GET',
                    url: "{{ route('orders.exportexcel') }}",
                    data: {
                        "daterange1": date_range1,
                        "status1": status1
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
                        a.attr("download", 'Daftar Pesanan-' + status1 + '-Tanggal-' +
                            date_range1 + '.xlsx');
                        a.attr("href", downloadURL);
                        $("body").append(a);
                        a[0].click();
                        $("body").remove(a);
                    }
                });
            });

            // Sync order status
            $(document).on('click', '.js-sync-order-btn', function(e) {
                const el = $(e.target);

                Swal.fire({
                        title: 'Sinkronkan Data Pesanan',
                        text: 'Anda yakin ingin menyinkronkan data pesanan ini? Dengan menyinkronkan ' +
                            'pesanan ini Anda akan memperoleh status terbaru dari pesanan yang telah ada' +
                            ' di Baleomol.com',
                        icon: 'warning',
                        allowOutsideClick: false,
                        showCancelButton: true,
                        confirmButtonText: 'Lanjutkan',
                        cancelButtonText: 'Batal',
                    })
                    .then(function(res) {
                        if (res.value) {
                            Swal.fire({
                                showCloseButton: false,
                                showConfirmButton: false,
                                icon: 'info',
                                title: 'Harap Tunggu',
                                text: 'Sedang memproses permintaan sinkron data Anda...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                onBeforeOpen: function() {
                                    Swal.showLoading();
                                },
                            });

                            setTimeout(function() {
                                const data = {
                                    order_id: Number(el.data('id'))
                                };
                                const ajaxConfigs = {
                                    url: '{{ url('/api/sync-order') }}',
                                    data: data,
                                    method: 'POST',
                                    dataType: 'json',
                                    failed: function(err) {
                                        Swal.fire('Terjadi Kesalahan', JSON.stringify({
                                            err
                                        }), 'error');
                                    },
                                    success: function(res) {
                                        if (res.status == 'success') {
                                            const data = res.data;

                                            Swal.fire(
                                                'Data Berhasil Diperbarui',
                                                `Pesanan #${data.origin_order_code} berhasil diperbarui. Anda dapat memperbarui lagi pesanan ini setelah 15 menit`,
                                                'success'
                                            ).then(function() {
                                                getDataFiltered();
                                            });
                                        } else {
                                            const err = res.errors || {};

                                            Swal.fire(
                                                err.title || 'Terjadi Kesalahan',
                                                err.detail ||
                                                'Mohon maaf terjadi kesalahan saat ' +
                                                'menyinkronkan data. Silahkan coba kembali ' +
                                                'beberapa saat lagi',
                                                'warning'
                                            );
                                        }
                                    }
                                };

                                $.ajax(ajaxConfigs);
                            }, 900);
                        }
                    });
            });

        });
    </script>
@endpush
