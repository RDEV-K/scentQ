<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 | Page Not Found!</title>
    @vite('resources/js/app.js')
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="nav-menu">
                <div class="brand">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('images/logo-dark.svg') }}" class=""
                            style="width: 180px;margin-inline-start: 10px" alt="{{ config('app.name') }}" />
                    </a>
                </div>
                <nav class="tw-hidden sm:tw-block">
                    <ul>
                        <li class="dropdown_custom">
                            <a href="{{ route('new.arrivals') }}" class="dropdown-toggle">
                                {{ __('New') }}
                            </a>
                        </li>

                        <li class="dropdown_custom">
                            <a href="{{ route('filter', 'perfume') }}" class="dropdown-toggle">
                                {{ __('Perfumes') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('filter', 'cologne') }}">
                                {{ __('Colognes') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('brands') }}">
                                {{ __('Brands') }}
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <section class="bg-white tw-flex lg:tw-flex-row tw-flex-col-reverse lg:tw-items-center">
        <div class="lg:tw-w-1/2 tw-w-full">
            <img src="{{ asset('images/errors/error-page.webp') }}" alt=""
                class="tw-w-full tw-h-[888px] tw-object-cover">
        </div>
        <div class="lg:tw-w-1/2 tw-w-full tw-flex tw-justify-center tw-items-center lg:tw-px-[124px]">
            <div class="container lg:tw-max-w-[636px] tw-py-10 lg:tw-py-0">
                <h2 class="tw-text-black lg:tw-text-5xl tw-text-3xl tw-font-semibold tw-mb-4 tw-font-TT-Norms">
                    Oops! Page not found.
                </h2>
                <p class="lg:tw-text-lg tw-text-sm tw-text-[#4D4D4D] tw-mb-6 !tw-font-light">
                    Sorry, the page you are looking for doesn’t
                    exist or an other error occurred. Go back, or head over to scentq.com to
                    choose new direction
                </p>
                <div class="tw-flex tw-gap-3">
                    <a href="/"
                        class="tw-max-h-14 tw-py-4 tw-px-12 tw-text-base tw-no-underline tw-bg-[#000] tw-text-white">
                        Go Home
                    </a>
                    {{-- <a href="/"
                        class="tw-max-h-14 tw-py-3.5 tw-px-[30px] tw-text-base tw-no-underline tw-border-2 tw-border-black tw-text-black">
                        Go Home
                    </a> --}}
                </div>
            </div>
        </div>
    </section>

    <section class="footer">
        <div class="container tw-mt-16">
            <div class="row gx-5">
                <div class="col-md-3">
                    <div class="footer-content">
                        <a href="/" class="!tw-no-underline tw-flex tw-items-center">
                            <div class="mb-3 footer-logo">
                                <img class="!tw-h-10 !tw-mr-2" src="{{ asset('images/footer-logo.png') }}" alt="{{ config('app.name') }}" />
                                <img src="{{ asset('images/logo-light.svg') }}" alt="{{ config('app.name') }}" />
                            </div>
                        </a>
                        <p>
                            Discover new fragrances every
                            {{ $current_plan?->interval_count }} month(s) for
                            {{ currencyConvertWithSymbol($current_plan?->total_price) }}
                        </p>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-8 col-md-8 col-lg-9">
                            <div class="footer-content footer-content-about">
                                <div class="row gx-4">
                                    <div class="col-12 col-sm-4">
                                        <h6>
                                            {{ __('About' . config('app.name')) }}
                                        </h6>
                                        <ul class="mt-3">
                                            <li>
                                                <a href="{{ route('page', 'about-us') }}">
                                                    {{ __('About Us') }}
                                                </a>
                                            </li>
                                            <!-- <li><Link href="#">Help</Link></li>
                                            <li><Link href="#">For press</Link></li> -->
                                        </ul>
                                    </div>
                                    <div class="col-8">
                                        <h6>{{ __('Store') }}</h6>
                                        <ul class="mt-3">
                                            <li>
                                                <a href="{{ route('brands') }}">
                                                    {{ __('All Brands') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('filter', 'perfume') }}">
                                                    {{ __('Shop Perfumes') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('filter', 'cologne') }}">
                                                    {{ __('Shop Colognes') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="icons-row  col-sm-4 col-md-4 col-lg-3 ">
                            <div class="footer-content">
                                <h6>{{ __('Social Media') }}</h6>
                                <div class="footer-social-icon mt-3">
                                    @foreach ($social_media as $key => $media)
                                        <a href="{{ $media->link }}">
                                            <img src="{{ $media->icon_url }}" alt="{{ $media->name }}" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom align-items-center">
                <p class="m-0">
                    © {{ config('app.name') }} {{ date('Y') }}
                </p>
                <div class="bottom-link">
                    <a :href="route('page', 'privacy-policy')">
                        {{ __('Privacy Policy') }}
                    </a>
                    <a :href="route('page', 'refund-policy')">
                        {{ __('Refund Policy') }}
                    </a>
                    <a :href="route('page', 'terms-and-conditions')">
                        {{ __('Terms And Conditions') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
