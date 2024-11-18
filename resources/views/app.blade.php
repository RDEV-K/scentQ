<!DOCTYPE html>
@php
    $code = config('misc.lang') ?? 'en';
@endphp
<html lang="{{ $code ?? 'en' }}" dir="{{ config('misc.dir') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="p:domain_verify" content="9e30edf45bbb7f3438b2c14fcf4f6211" />
    <link rel="icon" id="favicon-area" href="{{ asset('favicon-white.png') }}">
    <link rel="mask-icon" href="{{ asset(config('misc.icon')) }}" color="#000">
    <link rel="apple-touch-icon" href="{{ asset(config('misc.icon')) }}">
    {!! SEO::generate() !!}
    @routes
    {{-- <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"> --}}
    {{-- @if (app()->environment('production'))
        <link rel="preconnect" href="{{ config('app.asset_url') }}">
        <link rel="dns-prefetch" href="{{ config('app.asset_url') }}">
        <link crossorigin href="https://{{ config('scout.algolia.id') }}-dsn.algolia.net" rel="preconnect" />
    @endif --}}
    {{-- <link rel="stylesheet" href="{{ mix('/fonts/style.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('css/improved.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('css/vue-datepicker.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('css/vue-toast.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script> --}}
    {{-- @inertiaHead --}}
    <!-- Start Posthog tracking script -->
    <script>
        ! function(t, e) {
            var o, n, p, r;
            e.__SV || (window.posthog = e, e._i = [], e.init = function(i, s, a) {
                function g(t, e) {
                    var o = e.split(".");
                    2 == o.length && (t = t[o[0]], e = o[1]), t[e] = function() {
                        t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                }(p = t.createElement("script")).type = "text/javascript", p.async = !0, p.src = s.api_host +
                    "/static/array.js", (r = t.getElementsByTagName("script")[0]).parentNode.insertBefore(p, r);
                var u = e;
                for (void 0 !== a ? u = e[a] = [] : a = "posthog", u.people = u.people || [], u.toString = function(
                        t) {
                        var e = "posthog";
                        return "posthog" !== a && (e += "." + a), t || (e += " (stub)"), e
                    }, u.people.toString = function() {
                        return u.toString(1) + ".people (stub)"
                    }, o =
                    "capture identify alias people.set people.set_once set_config register register_once unregister opt_out_capturing has_opted_out_capturing opt_in_capturing reset isFeatureEnabled onFeatureFlags getFeatureFlag getFeatureFlagPayload reloadFeatureFlags group updateEarlyAccessFeatureEnrollment getEarlyAccessFeatures getActiveMatchingSurveys getSurveys"
                    .split(" "), n = 0; n < o.length; n++) g(u, o[n]);
                e._i.push([i, s, a])
            }, e.__SV = 1)
        }(document, window.posthog || []);
        posthog.init('phc_z8KZD7hSmuz3tUkojFuDwsvmroDSf3CbVQ3HF15FhEj', {
            api_host: 'https://app.posthog.com'
        })
    </script>
    <!-- End posthog tracking script  -->
    <!-- Google tag (gtag.js) -->
    <script defer src="https://www.googletagmanager.com/gtag/js?id=G-BS6M88D3J5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-BS6M88D3J5');
    </script>
    <!-- Google analytics -->
    @vite('resources/js/app.js')
    <style>
        @import url('https://fonts.cdnfonts.com/css/trebuchet-ms-2');

        .product-img-box img {
            max-width: 412 !important;
            height: 412px !important;
        }

        .form-floating>.form-control:focus,
        .form-floating>.form-control:not(:placeholder-shown),
        .form-floating>.form-control-plaintext:focus,
        .form-floating>.form-control-plaintext:not(:placeholder-shown) {
            padding-top: 1.625rem !important;
            padding-bottom: 0.625rem;
        }

        .top-menu .profile-menuitem .dropdown-menu {
            min-width: 350px;
            top: 20px !important;
            padding: 20px;
            text-align: right;
        }

        .product-img-box img {
            max-width: 412px !important;
            height: 412px !important;
        }

        .cart-custom-btn {
            border: 1px solid #000 !important;
        }

        .same-size {
            width: 270px;
        }

        .product-card {
            background: var(--secondary) !important;
        }

        /* .products-list-row {
            row-gap: 24px !important;
        } */

        @media(min-width: 1024px) {
            .view-more .btn {
                width: 29%;
            }
        }

        @media(max-width: 767px) {
            .common-header-top-section {
                display: none !important;
            }

            /*.search-wrapper{
                display: none;
            }*/
            .mobile-menu-wrap {
                height: 50px !important;
            }

            .offcanvas-area {
                top: 65px !important;
            }
        }

        @media(max-width: 500px) {
            .footer .col-8.col-md-8.col-lg-9 {
                width: 100% !important;
            }

            .footer .col-4.col-md-4.col-lg-3 {
                width: 100% !important;
                margin-top: 10px;
            }

            .footer .row.gx-4 .col-8 {
                width: 100% !important;
            }

            html[lang='az'] .slider-price {
                font-size: 24px;
            }

            html[lang='az'] .btn .azn {
                font-size: 8px !important;
            }

            html[lang='az'] button .azn {
                font-size: 8px !important;
            }
        }

        .cart-minus-btn {
            position: relative;
            top: -5px;
            font-size: 21px;
        }

        .cart-minus-btn {
            position: relative;
            top: -5px;
            font-size: 21px;
        }

        .VIpgJd-ZVi9od-aZ2wEe-wOHMyf {
            display: none !important;
        }

        body .product-card {
            font-family: 'Trebuchet MS', sans-serif !important;
        }

        .form-floating>.form-control {
            height: calc(3rem + 0px) !important;
            line-height: 100% !important;
        }

        .form-floating>label {
            padding: 12px 12px !important;
        }

        .form-floating>.form-control:-webkit-autofill~label {
            opacity: 0.65 !important;
            transform: scale(0.85) translateY(-0.7rem) translateX(0.15rem) !important;
        }
    </style>

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '433743719465782');
        fbq('track', 'PageView');
        fbq('track', 'Contact');
        fbq('track', 'ViewContent');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=433743719465782&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body>
    @inertia

    <script>
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.getElementById('favicon-area').href = "{{ asset('favicon-white.png') }}";
        } else {
            document.getElementById('favicon-area').href = "{{ asset('favicon-black.png') }}";
        }
    </script>

    <!--Start of Tidlo Script-->
    {{-- <script src="//code.tidio.co/hbnqby8tuywxzsypmo29lamerj3ubawh.js" async></script> --}}
    <!--End of Tidlo Script-->

    <!--Start of Tawk.to Script-->
    <script defer type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.defer = true; // Changed async to defer
            s1.src = 'https://embed.tawk.to/6503c2cb0f2b18434fd89e77/1habb1raq';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <!-- Add a container for the Google Translate button -->

    <!-- Auto Transalate for AZ country  -->
    @if ($code == 'az')
        <script>
            var element = document.getElementsByTagName('body');
            console.log(element);
            element[0].classList.add('azn');
        </script>
    @endif




    <div id="google_translate_element" style="display:none"></div>
    <script type="text/javascript">
        function loadGoogleTranslate() {
            var gtScript = document.createElement('script');
            gtScript.type = 'text/javascript';
            gtScript.async = true;
            gtScript.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            document.body.appendChild(gtScript);
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: '{{ $code }}'
            }, 'google_translate_element');
        }

        function setGoogleTranslateCookie(value, expirationMinutes) {
            var d = new Date();
            d.setTime(d.getTime() + (expirationMinutes * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = "googtrans=" + value + ";" + expires + ";path=/";
        }

        setGoogleTranslateCookie("/en/{{ $code }}", 60);

        window.onload = function() {
            loadGoogleTranslate();
        };
    </script>

    <style>
        .VIpgJd-ZVi9od-ORHb-OEVmcd {
            left: 0 !important;
            top: 0 !important;
            height: 0px !important;
            width: 0px !important;
            z-index: -0 !important;
            position: relative !important;
            border: none;
            border-bottom: 0px;
            margin: 0;
            box-shadow: 0;
        }

        body {
            top: 0 !important;
        }

        @media (max-width: 550px) {
            body.azn .btn-lg {
                font-size: 7px !important;
            }
        }

        @media (max-width: 767px) {

            body.azn .product-list-hover-nav .faq-stick-btn,
            body.azn .product-list-hover-nav .continue-stick-btn {
                padding-inline-start: 0px !important;
                padding-inline-end: 0px !important;
            }
        }
    </style>

</body>

</html>
