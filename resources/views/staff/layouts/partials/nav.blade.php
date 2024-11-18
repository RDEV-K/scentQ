<nav class="navbar navbar-light navbar-glass navbar-top sticky-kit navbar-expand">

    <button class="btn navbar-toggler-humburger-icon navbar-toggler mr-1 mr-sm-3" type="button" data-toggle="collapse"
        data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false"
        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
    </button>
    <a class="navbar-brand mr-1 mr-sm-3" href="{{ route('staff.dashboard') }}">
        <div class="d-flex align-items-center">
            <img width="35" height="35" src="{{ asset('images/logo-dark.png') }}"
                alt="{{ config('app.name') }}" />
            <!-- Generator: Adobe Illustrator 26.0.1, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
            <svg width="90" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 185 33"
                style="enable-background:new 0 0 185 33;" xml:space="preserve">
                <g>
                    <path d="M18.3,9.1c-0.9-1.6-3.5-3-6.4-3C8,6,6.2,7.6,6.2,9.7c0,2.4,2.8,3,6,3.4c5.7,0.7,10.9,2.2,10.9,8.7c0,6.1-5.3,8.7-11.4,8.7
                                    C6.3,30.4,2,28.7,0,23.7l4.3-2.2c1.2,3,4.3,4.3,7.6,4.3c3.2,0,6.2-1.1,6.2-4.1c0-2.6-2.7-3.6-6.3-4C6.3,17.1,1.2,15.6,1.2,9.5
                                    c0-5.6,5.5-7.9,10.5-7.9c4.2,0,8.6,1.2,10.6,5.4L18.3,9.1z" />
                    <path
                        d="M56.7,26.3c-2.8,2.8-6.4,4-10.3,4c-10.1,0-14.3-7-14.4-14C32,9.2,36.6,2,46.4,2c3.7,0,7.2,1.4,9.9,4.2l-3.4,3.3
                                    c-1.8-1.8-4.2-2.6-6.5-2.6c-6.5,0-9.4,4.9-9.3,9.4c0,4.5,2.6,9.2,9.3,9.2c2.4,0,5-1,6.8-2.8L56.7,26.3z" />
                    <path d="M85.4,29.7H65.1c0-9.1,0-18.2,0-27.2h20.3v5H70.2v6.3h14.7v4.8H70.2v6.1h15.2V29.7z" />
                    <path d="M113.6,2.5h5.1v27.2h-3.2v0l-14.2-18.4v18.4h-5.1V2.5h4.1l13.3,16.9V2.5z" />
                    <path d="M136.1,7.2h-8.6V2.5c7.8,0,14.4,0,22.3,0v4.7h-8.6v22.5h-5.1V7.2L136.1,7.2z" />
                    <path d="M185.1,15.8c0,3.1-0.8,6.3-2.5,8.9l3.2,3.2l-3.6,3.6l-3.3-3.3c-2,1.3-4.6,2-7.7,2c-9.6,0-13.9-7-13.9-14.1
                                    c0-7.1,4.4-14.2,13.9-14.2C180.7,1.8,184.9,8.8,185.1,15.8z M162.3,16.2c0.1,4.5,3,9.2,8.9,9.2c6.1,0,9.1-5.2,8.9-9.8
                                    c-0.2-4.4-2.5-9.1-8.9-9.1C164.8,6.5,162.2,11.6,162.3,16.2z" />
                </g>
            </svg>
            {{-- <img class="mr-2" src="{{ config('misc.logo') }}" alt="{{ config('app.name') }}" width="40" />
            <span class="text-sans-serif">
                {{ config('app.name') }}
            </span> --}}
        </div>
    </a>
    {{--    <ul class="navbar-nav align-items-center d-none d-lg-block"> --}}
    {{--        <li class="nav-item"> --}}
    {{--            <div class="search-box"> --}}
    {{--                <form class="position-relative" data-toggle="search" data-display="static"> --}}

    {{--                    <input class="form-control search-input" type="search" placeholder="Search..." aria-label="Search"/> --}}
    {{--                    <span class="fas fa-search search-box-icon"></span> --}}

    {{--                </form> --}}

    {{--                <button class="close" type="button" data-dismiss="search"><span class="fas fa-times"></span></button> --}}
    {{--                <div class="dropdown-menu"> --}}
    {{--                    <div class="scrollbar perfect-scrollbar py-3" style="height: 24rem;"> --}}
    {{--                        <h6 class="dropdown-header px-card pt-0 pb-2">Recently Browsed</h6> --}}
    {{--                        <a class="dropdown-item fs--1 px-card py-1 hover-primary" href="../pages/events.html"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <span class="fas fa-circle mr-2 text-300 fs--2"></span> --}}

    {{--                                <div class="font-weight-normal">Pages <span --}}
    {{--                                        class="fas fa-chevron-right mx-1 text-500 fs--2" --}}
    {{--                                        data-fa-transform="shrink-2"></span> Events --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}
    {{--                        <a class="dropdown-item fs--1 px-card py-1 hover-primary" href="../e-commerce/customers.html"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <span class="fas fa-circle mr-2 text-300 fs--2"></span> --}}

    {{--                                <div class="font-weight-normal">E-commerce <span --}}
    {{--                                        class="fas fa-chevron-right mx-1 text-500 fs--2" --}}
    {{--                                        data-fa-transform="shrink-2"></span> Customers --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}

    {{--                        <hr class="border-200"/> --}}
    {{--                        <h6 class="dropdown-header px-card pt-0 pb-2">Suggested Filter</h6> --}}
    {{--                        <a class="dropdown-item px-card py-1 fs-0" href="../e-commerce/customers.html"> --}}
    {{--                            <div class="d-flex align-items-center"><span --}}
    {{--                                    class="badge font-weight-medium text-decoration-none mr-2 badge-soft-warning">customers:</span> --}}
    {{--                                <div class="flex-1 fs--1">All customers list</div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}
    {{--                        <a class="dropdown-item px-card py-1 fs-0" href="../pages/events.html"> --}}
    {{--                            <div class="d-flex align-items-center"><span --}}
    {{--                                    class="badge font-weight-medium text-decoration-none mr-2 badge-soft-success">events:</span> --}}
    {{--                                <div class="flex-1 fs--1">Latest events in current month</div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}
    {{--                        <a class="dropdown-item px-card py-1 fs-0" href="../e-commerce/product-grid.html"> --}}
    {{--                            <div class="d-flex align-items-center"><span --}}
    {{--                                    class="badge font-weight-medium text-decoration-none mr-2 badge-soft-info">products:</span> --}}
    {{--                                <div class="flex-1 fs--1">Most popular products</div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}

    {{--                        <hr class="border-200"/> --}}
    {{--                        <h6 class="dropdown-header px-card pt-0 pb-2">Files</h6> --}}
    {{--                        <a class="dropdown-item px-card py-2" href="#!"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <div class="file-thumbnail mr-2"><img class="border h-100 w-100 fit-cover rounded-lg" --}}
    {{--                                                                      src="../assets/img/products/3-thumb.png" alt=""/> --}}
    {{--                                </div> --}}
    {{--                                <div class="flex-1"> --}}
    {{--                                    <h6 class="mb-0">iPhone</h6> --}}
    {{--                                    <p class="fs--2 mb-0"><span class="font-weight-semi-bold">Antony</span><span --}}
    {{--                                            class="font-weight-medium text-600 ml-2">27 Sep at 10:30 AM</span></p> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}
    {{--                        <a class="dropdown-item px-card py-2" href="#!"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <div class="file-thumbnail mr-2"><img class="img-fluid" --}}
    {{--                                                                      src="../assets/img/icons/zip.png" alt=""/></div> --}}
    {{--                                <div class="flex-1"> --}}
    {{--                                    <h6 class="mb-0">Falcon v1.8.2</h6> --}}
    {{--                                    <p class="fs--2 mb-0"><span class="font-weight-semi-bold">John</span><span --}}
    {{--                                            class="font-weight-medium text-600 ml-2">30 Sep at 12:30 PM</span></p> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}

    {{--                        <hr class="border-200"/> --}}
    {{--                        <h6 class="dropdown-header px-card pt-0 pb-2">Members</h6> --}}
    {{--                        <a class="dropdown-item px-card py-2" href="../pages/profile.html"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <div class="avatar avatar-l status-online mr-2"> --}}
    {{--                                    <img class="rounded-circle" src="../assets/img/team/1.jpg" alt=""/> --}}

    {{--                                </div> --}}
    {{--                                <div class="flex-1"> --}}
    {{--                                    <h6 class="mb-0">Anna Karinina</h6> --}}
    {{--                                    <p class="fs--2 mb-0">Technext Limited</p> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}
    {{--                        <a class="dropdown-item px-card py-2" href="../pages/profile.html"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <div class="avatar avatar-l mr-2"> --}}
    {{--                                    <img class="rounded-circle" src="../assets/img/team/2.jpg" alt=""/> --}}

    {{--                                </div> --}}
    {{--                                <div class="flex-1"> --}}
    {{--                                    <h6 class="mb-0">Antony Hopkins</h6> --}}
    {{--                                    <p class="fs--2 mb-0">Brain Trust</p> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}
    {{--                        <a class="dropdown-item px-card py-2" href="../pages/profile.html"> --}}
    {{--                            <div class="d-flex align-items-center"> --}}
    {{--                                <div class="avatar avatar-l mr-2"> --}}
    {{--                                    <img class="rounded-circle" src="../assets/img/team/3.jpg" alt=""/> --}}

    {{--                                </div> --}}
    {{--                                <div class="flex-1"> --}}
    {{--                                    <h6 class="mb-0">Emma Watson</h6> --}}
    {{--                                    <p class="fs--2 mb-0">Google</p> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </a> --}}

    {{--                    </div> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </li> --}}
    {{--    </ul> --}}
    <ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center">
        <li data-toggle="tooltip" data-placement="left" title="Update Cache Data" class="nav-item">
            <a class="nav-link settings-popover" href="{{ route('cache.clear') }}">
                <span class="position-absolute a-0 d-flex flex-center"><span
                        class="position-absolute a-0 d-flex flex-center">
                        <svg fill="#2A7BE4" height="20" width="20" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 214.367 214.367" xml:space="preserve">
                            <path d="M202.403,95.22c0,46.312-33.237,85.002-77.109,93.484v25.663l-69.76-40l69.76-40v23.494
                            c27.176-7.87,47.109-32.964,47.109-62.642c0-35.962-29.258-65.22-65.22-65.22s-65.22,29.258-65.22,65.22
                            c0,9.686,2.068,19.001,6.148,27.688l-27.154,12.754c-5.968-12.707-8.994-26.313-8.994-40.441C11.964,42.716,54.68,0,107.184,0
                            S202.403,42.716,202.403,95.22z" />
                        </svg>
                    </span>
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link settings-popover" href="{{ route('staff.settings') }}">
                <span class="position-absolute a-0 d-flex flex-center"><span
                        class="position-absolute a-0 d-flex flex-center">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                fill="#2A7BE4">
                            </path>
                        </svg>
                    </span>
                </span>
            </a>
        </li>
        @php
            $pending_orders = \App\Models\Order::query()
                ->with('user')
                ->pending()
                ->latest('id')
                ->limit(50)
                ->get();

            $total_pending = \App\Models\Order::pending()->count();
        @endphp
        <li class="nav-item dropdown dropdown-on-hover">
            <a class="nav-link @if ($total_pending) notification-indicator notification-indicator-primary @endif px-0 icon-indicator"
                id="navbarDropdownOrders" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><span class="fas fa-bars fs-4" data-fa-transform="shrink-6"></span></a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-card" aria-labelledby="navbarDropdownOrders">
                <div class="card card-notification shadow-none" style="max-width: 20rem">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h6 class="card-header-title mb-0">New Orders</h6>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-danger float-right">{{ $total_pending }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush font-weight-normal fs--1 perfect-scrollbar scrollbar"
                        style="max-height:50vh; overflow-y:auto;">
                        @foreach ($pending_orders as $porder)
                            <div class="list-group-item">
                                <a class="notification notification-flush bg-200"
                                    href="{{ route('staff.order.show', $porder->id) }}">
                                    <div class="notification-avatar">
                                        <div class="avatar avatar-2xl mr-3">
                                            <div class="avatar-name rounded-circle">
                                                <span>{{ $porder->user?->first_name[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-body">
                                        <p class="mb-1"><strong>Order #{{ $porder->id }}</strong> | <strong
                                                class="float-right">Gross:
                                                {{ currencyConvertWithSymbol($porder->gross_total) }}</strong>
                                        </p>
                                        <span class="notification-time"><span
                                                class="mr-1 fab fa-clock text-danger"></span>{{ $porder->created_at?->diffForHumans() }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-center border-top"><a class="card-link d-block"
                            href="{{ route('staff.order.index') }}">View all</a>
                    </div>
                </div>
            </div>

        </li>
        <li class="nav-item dropdown dropdown-on-hover"><a class="nav-link pr-0" id="navbarDropdownUser" href="#"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="{{ auth('staff')->user()->avatar }}"
                        alt="{{ auth('staff')->user()->name }}" />
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
                <div class="bg-white rounded-soft py-2">
                    <a class="dropdown-item" href="{{ route('staff.profile') }}">@lang('Profile')</a>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">@lang('Logout')</a>
                </div>
            </div>
        </li>
    </ul>
</nav>

<form action="{{ route('staff.logout') }}" method="post" id="logout-form" class="d-none">
    @csrf
</form>
