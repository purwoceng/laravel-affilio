@extends('authentication.components.auth')
@section('page_title', __('Masuk'))
@section('content')
    @include('authentication.components.logo')
    
    @if(count($errors) > 0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span>{{ $message }}</span>
            </div>
        @endforeach
    @endif

    <div class="login-form">
        <form
            class="form"
            id="kt_login_singin_form"
            action="{{ route('login') }}"
            method="POST">
            @csrf

            <div class="pb-5 pb-lg-15">
                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Login</h3>
            </div>

            <div class="form-group">
                <label class="font-size-h6 font-weight-bolder text-dark">Username / Email</label>
                <input
                    class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"
                    type="text"
                    name="login"
                    autocomplete="off"
                    value="{{ old('login') }}"
                    required
                    autofocus
                />
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-between mt-n5">
                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                            Lupa Password?
                        </a>
                    @endif
                </div>
                <input
                    class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"
                    type="password"
                    name="password"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="pb-lg-0 pb-5">
                <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Login</button>
            </div>
        </form>
    </div>
@endsection