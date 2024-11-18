<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ config('misc.icon') }}">

    <script src="{{ asset('assets/js/config.navbar-vertical.js') }}"></script>
    <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="">
    <link href="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
</head>

<body>

    <main class="main" id="top">
        <div class="container" data-layout="container">
            <div class="row flex-center min-vh-100 py-6">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <a class="d-flex flex-center mb-4" href="{{ url('/') }}">
                        <img width="55" height="55" src="{{ asset('images/logo-dark.png') }}"
                            alt="{{ config('app.name') }}" />
                        <!-- Generator: Adobe Illustrator 26.0.1, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                        <svg width="100" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 185 33" style="enable-background:new 0 0 185 33;" xml:space="preserve">
                            <g>
                                <path
                                    d="M18.3,9.1c-0.9-1.6-3.5-3-6.4-3C8,6,6.2,7.6,6.2,9.7c0,2.4,2.8,3,6,3.4c5.7,0.7,10.9,2.2,10.9,8.7c0,6.1-5.3,8.7-11.4,8.7
                                    C6.3,30.4,2,28.7,0,23.7l4.3-2.2c1.2,3,4.3,4.3,7.6,4.3c3.2,0,6.2-1.1,6.2-4.1c0-2.6-2.7-3.6-6.3-4C6.3,17.1,1.2,15.6,1.2,9.5
                                    c0-5.6,5.5-7.9,10.5-7.9c4.2,0,8.6,1.2,10.6,5.4L18.3,9.1z" />
                                <path
                                    d="M56.7,26.3c-2.8,2.8-6.4,4-10.3,4c-10.1,0-14.3-7-14.4-14C32,9.2,36.6,2,46.4,2c3.7,0,7.2,1.4,9.9,4.2l-3.4,3.3
                                    c-1.8-1.8-4.2-2.6-6.5-2.6c-6.5,0-9.4,4.9-9.3,9.4c0,4.5,2.6,9.2,9.3,9.2c2.4,0,5-1,6.8-2.8L56.7,26.3z" />
                                <path
                                    d="M85.4,29.7H65.1c0-9.1,0-18.2,0-27.2h20.3v5H70.2v6.3h14.7v4.8H70.2v6.1h15.2V29.7z" />
                                <path d="M113.6,2.5h5.1v27.2h-3.2v0l-14.2-18.4v18.4h-5.1V2.5h4.1l13.3,16.9V2.5z" />
                                <path d="M136.1,7.2h-8.6V2.5c7.8,0,14.4,0,22.3,0v4.7h-8.6v22.5h-5.1V7.2L136.1,7.2z" />
                                <path
                                    d="M185.1,15.8c0,3.1-0.8,6.3-2.5,8.9l3.2,3.2l-3.6,3.6l-3.3-3.3c-2,1.3-4.6,2-7.7,2c-9.6,0-13.9-7-13.9-14.1
                                    c0-7.1,4.4-14.2,13.9-14.2C180.7,1.8,184.9,8.8,185.1,15.8z M162.3,16.2c0.1,4.5,3,9.2,8.9,9.2c6.1,0,9.1-5.2,8.9-9.8
                                    c-0.2-4.4-2.5-9.1-8.9-9.1C164.8,6.5,162.2,11.6,162.3,16.2z" />
                            </g>
                        </svg>
                        {{-- <img class="mr-2" src="{{ config('misc.logo') }}" alt="{{ config('app.name') }}"
                            width="58" />
                        <span class="text-sans-serif font-weight-extra-bold fs-5 d-inline-block">
                            {{ config('app.name') }}
                        </span> --}}
                    </a>
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <link
        href="//fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
</body>

</html>
