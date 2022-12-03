@extends('authentication.components.auth')
@section('title', __('Lupa Password'))
@section('content')
    @include('authentication.components.logo')

    <div class="login-form">
        <form
            class="form"
            id="kt_login_forgot_form"
            action="{{ route('password.email') }}"
            method="POST">
            @csrf

            <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Lupa Password Anda?</h3>
                <p class="text-muted font-weight-bold font-size-h4">
                    Masukkan email atau username Anda untuk me-reset password
                </p>
            </div>

            <div class="form-group">
                <input
                    class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"
                    type="text"
                    name="login"
                    autocomplete="off"
                    placeholder="Email / username Anda"
                    value="{{ old('login') }}"
                    required
                    autofocus
                />
            </div>

            <div class="form-group d-flex flex-wrap">
                <button type="submit"
                    id="kt_login_forgot_form_submit_button"
                    class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">
                    Kirim
                </button>
                <a href="{{ route('login') }}" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Batal</a>
            </div>
        </form>
    </div>
@endsection