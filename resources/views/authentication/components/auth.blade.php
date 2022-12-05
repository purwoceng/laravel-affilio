<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Auth - Admin Aplikasi X</title>

    <link rel="stylesheet" href="{{ asset('css/pages/login/login.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/global/plugins.bundle.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/style.bundle.css') }}" type="text/css" />
    {{-- <link rel="stylesheet" href="{{ asset('') }}" type="text/css" /> --}}
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        <div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
            {{-- Main Content --}}
            @include('authentication.components.main')

            {{-- Aside Content --}}
            @include('authentication.components.aside')
        </div>
    </div>

    
    <script src="{{ asset('js/configs/global.config.js') }}"></script>
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
</body>
</html>