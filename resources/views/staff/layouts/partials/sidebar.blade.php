<nav class="navbar navbar-vertical navbar-expand-xl navbar-light">
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">

            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-toggle="tooltip"
                data-placement="left" title="Toggle Navigation">
                <span class="navbar-toggle-icon">
                    <span class="toggle-line">
                    </span>
                </span>
            </button>

        </div>
        <a class="navbar-brand" href="{{ route('staff.dashboard') }}">
            <div class="d-flex align-items-center py-3">
                <div class="tw-flex tw-items-center">
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
                            <path
                                d="M85.4,29.7H65.1c0-9.1,0-18.2,0-27.2h20.3v5H70.2v6.3h14.7v4.8H70.2v6.1h15.2V29.7z" />
                            <path d="M113.6,2.5h5.1v27.2h-3.2v0l-14.2-18.4v18.4h-5.1V2.5h4.1l13.3,16.9V2.5z" />
                            <path d="M136.1,7.2h-8.6V2.5c7.8,0,14.4,0,22.3,0v4.7h-8.6v22.5h-5.1V7.2L136.1,7.2z" />
                            <path d="M185.1,15.8c0,3.1-0.8,6.3-2.5,8.9l3.2,3.2l-3.6,3.6l-3.3-3.3c-2,1.3-4.6,2-7.7,2c-9.6,0-13.9-7-13.9-14.1
                                    c0-7.1,4.4-14.2,13.9-14.2C180.7,1.8,184.9,8.8,185.1,15.8z M162.3,16.2c0.1,4.5,3,9.2,8.9,9.2c6.1,0,9.1-5.2,8.9-9.8
                                    c-0.2-4.4-2.5-9.1-8.9-9.1C164.8,6.5,162.2,11.6,162.3,16.2z" />
                        </g>
                    </svg>
                </div>
                {{-- <img class="mr-2" src="{{ config('misc.logo') }}" alt="{{ config('app.name') }}" width="40" />
                <span class="text-sans-serif">
                    {{ config('app.name') }}
                </span> --}}
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content perfect-scrollbar scrollbar">
            <ul class="navbar-nav flex-column">

                <li class="nav-item @if (request()->is('staff/dashboard')) active @endif">
                    <a class="nav-link" href="{{ route('staff.dashboard') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-chart-pie"></span>
                            </span>
                            <span class="nav-link-text"> @lang('Dashboard')</span>
                        </div>
                    </a>
                </li>

                @able('manage_order')
                    <li class="nav-item {{ request()->is('staff/order*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#order" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/order*') ? 'true' : 'false' }}" aria-controls="order">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-th"></i>
                                </span>
                                <span class="nav-link-text">@lang('Orders')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/order*') ? 'show' : '' }}" id="order"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/order') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.order.index') }}">@lang('All Orders')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/order/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.order.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_product')
                    <li class="nav-item {{ request()->is('staff/product*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#product" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/product*') ? 'true' : 'false' }}"
                            aria-controls="product">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-air-freshener"></span>
                                </span>
                                <span class="nav-link-text">@lang('Products')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/product*') ? 'show' : '' }}" id="product"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/product') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.product.index') }}">@lang('All Products')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/product/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.product.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_brand')
                    <li class="nav-item {{ request()->is('staff/brand*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#brand" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/brand*') ? 'true' : 'false' }}" aria-controls="brand">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-bullseye"></i>
                                </span>
                                <span class="nav-link-text">@lang('Brands')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/brand*') ? 'show' : '' }}" id="brand"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/brand') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.brand.index') }}">@lang('All Brands')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/brand/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.brand.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_testimonial')
                    <li class="nav-item {{ request()->is('staff/testimonial*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#testimonials" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/brand*') ? 'true' : 'false' }}" aria-controls="brand">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fab fa-instagram"></i>
                                </span>
                                <span class="nav-link-text">@lang('Testimonials')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/testimonial*') ? 'show' : '' }}"
                            id="testimonials" data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/brand') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.testimonial.index') }}">@lang('All Testimonials')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/testimonial/create') ? 'active' : '' }}"><a
                                    class="nav-link"
                                    href="{{ route('staff.testimonial.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_staff')
                    <li
                        class="nav-item {{ request()->is('staff/role') || request()->is('staff/staff') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#staff" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/role') || request()->is('staff/staff') ? 'true' : 'false' }}"
                            aria-controls="staff">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-user-md"></span>
                                </span>
                                <span class="nav-link-text">@lang('Roles & Staff')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/role') || request()->is('staff/staff') ? 'show' : '' }}"
                            id="staff" data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/role') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.role.index') }}">@lang('Roles')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/staff') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.staff.index') }}">@lang('Staff')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                <li class="nav-item @if (request()->routeIs('staff.team-member.*')) active @endif">
                    <a class="nav-link" href="{{ route('staff.team-member.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-users"></span>
                            </span>
                            <span class="nav-link-text"> @lang('Team Member')</span>
                        </div>
                    </a>
                </li>

                @able('manage_taxonomy')
                    <li class="nav-item @if (request()->is('staff/taxonomy*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.taxonomy.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-align-right"></span>
                                </span>
                                <span class="nav-link-text"> @lang('Taxonomy')</span>
                            </div>
                        </a>
                    </li>
                @endable

                @able('manage_collection')
                    <li class="nav-item {{ request()->is('staff/collection*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#collection" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/collection*') ? 'true' : 'false' }}"
                            aria-controls="collection">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="far fa-folder-open"></i>
                                </span>
                                <span class="nav-link-text">@lang('Collections')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/collection*') ? 'show' : '' }}" id="collection"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/collection') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.collection.index') }}">@lang('All Collections')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/collection/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.collection.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_family')
                    <li class="nav-item {{ request()->is('staff/family*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#family" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/family*') ? 'true' : 'false' }}"
                            aria-controls="family">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-sitemap"></i>
                                    {{-- <i class="fas fa-snowflake"></i> --}}
                                </span>
                                <span class="nav-link-text">@lang('Families')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/family*') ? 'show' : '' }}" id="family"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/family') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.family.index') }}">@lang('All Families')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/family/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.family.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                <li class="nav-item {{ request()->is('staff/faq*') ? 'active' : '' }}">
                    <a class="nav-link dropdown-indicator" href="#faq" data-toggle="collapse" role="button"
                        aria-expanded="{{ request()->is('staff/faq*') ? 'true' : 'false' }}" aria-controls="faq">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <i class="fas fa-tasks"></i>
                            </span>
                            <span class="nav-link-text">@lang('FAQs')</span>
                        </div>
                    </a>
                    <ul class="nav collapse {{ request()->is('staff/faq*') ? 'show' : '' }}" id="faq"
                        data-parent="#navbarVerticalCollapse">
                        <li class="nav-item {{ request()->is('staff/faq') ? 'active' : '' }}"><a class="nav-link"
                                href="{{ route('staff.faq.index') }}">@lang('All FAQs')</a>
                        </li>
                        <li class="nav-item {{ request()->is('staff/faq/create') ? 'active' : '' }}"><a
                                class="nav-link" href="{{ route('staff.faq.create') }}">@lang('Add New')</a>
                        </li>
                    </ul>
                </li>

                @able('manage_label')
                    <li class="nav-item {{ request()->is('staff/label*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#label" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/label*') ? 'true' : 'false' }}" aria-controls="label">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-bookmark"></i>
                                </span>
                                <span class="nav-link-text">@lang('Labels')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/label*') ? 'show' : '' }}" id="label"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/label') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.label.index') }}">@lang('All Labels')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/label/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.label.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_note')
                    <li class="nav-item {{ request()->is('staff/note*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#note" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/note*') ? 'true' : 'false' }}" aria-controls="note">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-tasks"></i>
                                </span>
                                <span class="nav-link-text">@lang('Notes')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/note*') ? 'show' : '' }}" id="note"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/note') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.note.index') }}">@lang('All Notes')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/note/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.note.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_badge')
                    <li class="nav-item {{ request()->is('staff/badge*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#badge" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/badge*') ? 'true' : 'false' }}" aria-controls="badge">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-tags"></i>
                                </span>
                                <span class="nav-link-text">@lang('Badges')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/badge*') ? 'show' : '' }}" id="badge"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/badge') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.badge.index') }}">@lang('All Badges')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/badge/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.badge.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_productSubType')
                    <li class="nav-item @if (request()->is('staff/product-sub-type*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.product-sub-type.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-project-diagram"></i>
                                </span>
                                <span class="nav-link-text"> @lang('Product Sub Type')</span>
                            </div>
                        </a>
                    </li>
                @endable

                <li class="nav-item @if (request()->is('staff/first.month.discount*')) active @endif">
                    <a class="nav-link" href="{{ route('staff.first.month.discount') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-percentage"></span>
                            </span>
                            <span class="nav-link-text">
                                Subscribe Discount
                            </span>
                        </div>
                    </a>
                </li>

                <li class="nav-item @if (request()->is('staff/lang-translation*')) active @endif">
                    <a class="nav-link" href="{{ route('staff.lang-translation.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-language"></span>
                            </span>
                            <span class="nav-link-text">
                                Translations
                            </span>
                        </div>
                    </a>
                </li>

                @able('manage_coupon')
                    <li class="nav-item {{ request()->is('staff/coupon*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#coupon" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/coupon*') ? 'true' : 'false' }}"
                            aria-controls="coupon">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-memory"></i>
                                </span>
                                <span class="nav-link-text">@lang('Coupon')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/coupon*') ? 'show' : '' }}" id="coupon"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/coupon') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.coupon.index') }}">@lang('All Coupons')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/coupon/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.coupon.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_page')
                    <li class="nav-item {{ request()->is('staff/page*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#page" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/page*') ? 'true' : 'false' }}"
                            aria-controls="product">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-pager"></span>
                                </span>
                                <span class="nav-link-text">@lang('Page')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/page*') ? 'show' : '' }}" id="page"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/page') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.page.index') }}">@lang('All Pages')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/page/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.page.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_product')
                    <li class="nav-item @if (request()->is('staff/review*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.review.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-align-left"></span>
                                </span>
                                <span class="nav-link-text"> @lang('Reviews')</span>
                            </div>
                        </a>
                    </li>
                @endable

                @able('manage_productOfTheMonth')
                    <li class="nav-item {{ request()->is('staff/product-of-the-month*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#productOfTheMonth" data-toggle="collapse"
                            role="button"
                            aria-expanded="{{ request()->is('staff/product-of-the-month*') ? 'true' : 'false' }}"
                            aria-controls="productOfTheMonth">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-air-freshener"></span>
                                </span>
                                <span class="nav-link-text">@lang('Product Of The Months')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/product-of-the-month*') ? 'show' : '' }}"
                            id="productOfTheMonth" data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/product-of-the-month') ? 'active' : '' }}"><a
                                    class="nav-link"
                                    href="{{ route('staff.product-of-the-month.index') }}">@lang('All month')</a>
                            </li>
                            <li
                                class="nav-item {{ request()->is('staff/product-of-the-month/create') ? 'active' : '' }}">
                                <a class="nav-link"
                                    href="{{ route('staff.product-of-the-month.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_setting')
                    <li class="nav-item {{ request()->is('staff/plan*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#plan" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/plan*') ? 'true' : 'false' }}" aria-controls="plan">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-map-marked"></i>
                                </span>
                                <span class="nav-link-text">@lang('Plans')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/plan*') ? 'show' : '' }}" id="plan"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/plan') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('staff.plan.index') }}">@lang('All Plans')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/plan/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.plan.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_setting')
                    <li class="nav-item {{ request()->is('staff/shipping-policy*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#shipping-policy" data-toggle="collapse"
                            role="button"
                            aria-expanded="{{ request()->is('staff/shipping-policy*') ? 'true' : 'false' }}"
                            aria-controls="shipping-policy">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-ship"></i>
                                </span>
                                <span class="nav-link-text">@lang('Shipping Policies')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/shipping-policy*') ? 'show' : '' }}"
                            id="shipping-policy" data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/shipping-policy') ? 'active' : '' }}"><a
                                    class="nav-link"
                                    href="{{ route('staff.shipping-policy.index') }}">@lang('All Policies')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/shipping-policy/create') ? 'active' : '' }}"><a
                                    class="nav-link"
                                    href="{{ route('staff.shipping-policy.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_setting')
                    <li class="nav-item @if (request()->is('staff/queue-purchase*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.queue-purchase.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-align-left"></span>
                                </span>
                                <span class="nav-link-text"> @lang('Queue Purchase Policies')</span>
                            </div>
                        </a>
                    </li>
                @endable

                {{-- @able('manage_productOfTheMonth')
                <li class="nav-item {{ (request()->is('staff/product-of-the-month*'))?'active':'' }}">
                    <a class="nav-link dropdown-indicator" href="#product-of-the-month" data-toggle="collapse" role="button" aria-expanded="{{ (request()->is('staff/product-of-the-month*'))?'true':'false' }}" aria-controls="product-of-the-month">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </span>
                            <span class="nav-link-text">@lang('Product Of The Month')</span>
                        </div>
                    </a>
                    <ul class="nav collapse {{ (request()->is('staff/product-of-the-month*'))?'show':'' }}" id="product-of-the-month" data-parent="#navbarVerticalCollapse">
                        <li class="nav-item {{ request()->is('staff/product-of-the-month')?'active':'' }}"><a class="nav-link" href="{{ route('staff.product-of-the-month.index') }}">@lang('All Months')</a>
                        </li>
                        <li class="nav-item {{ request()->is('staff/product-of-the-month/create')?'active':'' }}"><a class="nav-link" href="{{ route('staff.product-of-the-month.create') }}">@lang('Add New')</a>
                        </li>
                    </ul>
                </li>
                @endable --}}

                @able('manage_customer')
                    <li class="nav-item {{ request()->is('staff/customer*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-indicator" href="#customer" data-toggle="collapse" role="button"
                            aria-expanded="{{ request()->is('staff/customer*') ? 'true' : 'false' }}"
                            aria-controls="customer">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-users"></span>
                                </span>
                                <span class="nav-link-text">@lang('Customers')</span>
                            </div>
                        </a>
                        <ul class="nav collapse {{ request()->is('staff/customer*') ? 'show' : '' }}" id="customer"
                            data-parent="#navbarVerticalCollapse">
                            <li class="nav-item {{ request()->is('staff/customer') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.customer.index') }}">@lang('All Customer')</a>
                            </li>
                            <li class="nav-item {{ request()->is('staff/customer/create') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('staff.customer.create') }}">@lang('Add New')</a>
                            </li>
                        </ul>
                    </li>
                @endable

                @able('manage_subscribers')
                    <li class="nav-item @if (request()->is('staff/subscribers*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.subscribers.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-file"></span>
                                </span>
                                <span class="nav-link-text"> @lang('Subscribers')</span>
                            </div>
                        </a>
                    </li>
                @endable

                @able('manage_subscribers')
                    <li class="nav-item @if (request()->is('staff/texts*')) active @endif">
                        <a class="nav-link" href="{{ url('staff/texts') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-file-alt"></span> <!-- Changed the icon here -->
                                </span>
                                <span class="nav-link-text"> @lang('Text')</span>
                            </div>
                        </a>
                    </li>
                @endable

                @able('manage_setting')
                    <li class="nav-item @if (request()->is('staff/quiz-item*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.quiz-item.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fas fa-align-left"></span>
                                </span>
                                <span class="nav-link-text"> @lang('Quiz')</span>
                            </div>
                        </a>
                    </li>
                @endable

                @able('manage_setting')
                    <li class="nav-item @if (request()->is('staff/gateway*')) active @endif">
                        <a class="nav-link" href="{{ route('staff.gateway.index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <i class="fas fa-door-open"></i>
                                </span>
                                <span class="nav-link-text"> @lang('Gateways')</span>
                            </div>
                        </a>
                    </li>
                @endable
                {{-- @able('manage_setting') --}}
                <li class="nav-item @if (request()->is('staff/webhook*')) active @endif">
                    <a class="nav-link" href="{{ route('staff.webhook.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <i class="fas  fa-sticky-note"></i>
                            </span>
                            <span class="nav-link-text"> @lang('Webhook')</span>
                        </div>
                    </a>
                </li>
                {{-- @endable --}}
            </ul>
        </div>
    </div>
</nav>
