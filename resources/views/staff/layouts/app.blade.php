<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="icon" id="favicon-area" href="{{ asset('favicon-white.png') }}">

    <script src="{{ asset('assets/js/config.navbar-vertical.js') }}"></script>
    <link rel="preconnect" href="//fonts.gstatic.com/" crossorigin="">
    <link href="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">
    @yield('css_libs')
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            @include('staff.layouts.partials.sidebar')
            <div class="content">
                @include('staff.layouts.partials.nav')
                @yield('content')
                <footer class="mt-5">
                    <p class="mb-0 text-600">{!! config('misc.footer_text') !!}</p>
                </footer>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/lib/@fortawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/lib/stickyfilljs/stickyfill.min.js') }}"></script>
    <script src="{{ asset('assets/lib/sticky-kit/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('assets/lib/is_js/is.min.js') }}"></script>
    <script src="{{ asset('assets/lib/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <link
        href="//fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    @yield('js_libs')
    <script src="//cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser-polyfill.min.js"></script>
    <script src="{{ asset('assets/lib/progressbar.js/progressbar.min.js') }}"></script>
    <script>
        window.mediaManagerPath = "{{ url('/') }}/"

        function openMediaManager(callback, type, title) {
            type = type || 'image'
            title = title || 'FileManager'
            window.open('{{ route('staff.unisharp.lfm.show') }}?type=' + type, title, 'width=900,height=600');
            window.SetUrl = callback
        }
    </script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    @yield('js')
    <script>
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.getElementById('favicon-area').href = "{{ asset('favicon-white.png') }}";
        } else {
            document.getElementById('favicon-area').href = "{{ asset('favicon-black.png') }}";
        }
    </script>
</body>

</html>
