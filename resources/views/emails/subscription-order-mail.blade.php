<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        body,
        body *:not(html):not(style):not(br):not(tr):not(code) {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
                'Apple Color Emoji',
                'Segoe UI Emoji',
                'Segoe UI Symbol';
            position: relative;
        }

        footer {
            background: #b12e2e !important;
        }


        .content {
            -webkit-text-size-adjust: none;
            background-color: #f7fafc;
            color: #718096;
            height: 100%;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        p,
        ul,
        ol,
        blockquote {
            line-height: 1.4;
            text-align: start;
        }

        a {
            color: #3869d4;
        }

        a img {
            border: none;
        }

        /* Typography */

        h1 {
            /* color: #3d4852;
                                                            font-size: 18px;
                                                            font-weight: bold;
                                                            margin-top: 0;
                                                            text-align: start; */
            font-style: normal;
            font-weight: 600;
            font-size: 32px;
            line-height: 40px;
            color: #000000;
            margin-bottom: 12px;
        }

        h2 {
            font-size: 16px;
            font-weight: bold;
            margin-top: 0;
            text-align: start;
        }

        h3 {
            font-size: 14px;
            font-weight: bold;
            margin-top: 0;
            text-align: start;
        }

        p {
            /* font-size: 16px;
                                                            line-height: 1.5em;
                                                            margin-top: 0;
                                                            text-align: start; */
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 22px;
            color: #000000;
        }

        p.sub {
            font-size: 12px;
        }

        img {
            max-width: 100%;
        }

        /* Layout */

        .wrapper {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            background-color: black;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .content {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Header */

        .header {
            text-align: center;
        }

        .inner-header {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 600px;
            background-color: #000;
            margin: 0 auto;
            padding: 20px 0;
            width: 600px;
        }

        .header a {
            color: #3d4852;
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
        }

        /* Logo */

        .logo {
            height: 32px;
            max-height: 32px;
            width: 100%;
        }

        /* Body */

        .body {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            /* background-color: #edf2f7; */
            /* border-bottom: 1px solid #edf2f7;
                                                            border-top: 1px solid #edf2f7; */
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .inner-body {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 600px;
            background-color: #ffffff;
            border-color: #e8e5ef;
            border-radius: 2px;
            border-width: 1px;
            -webkit-box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);
            box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);
            margin: 0 auto;
            padding: 0;
            width: 600px;
        }

        /* Subcopy */

        .subcopy {
            border-top: 1px solid #e8e5ef;
            margin-top: 25px;
            padding-top: 25px;
        }

        .subcopy p {
            font-size: 14px;
        }

        /* Footer */

        .footer {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 600px;
            margin: 0 auto;
            padding: 0;
            text-align: center;
            width: 600px;
        }

        .footer p {
            color: #b0adc5;
            font-size: 12px;
            text-align: center;
        }

        .footer a {
            color: #b0adc5;
            text-decoration: underline;
        }

        *,
        ul {
            padding: 0;
            margin: 0
        }

        a,
        header .logo {
            display: inline-block
        }

        footer .copyright,
        footer .footer-menu a {
            font-style: normal;
            color: white;
            text-align: center
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        ul {
            list-style: none
        }

        a {
            text-decoration: none
        }

        header {
            background: #000;
            padding: 20px 40px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        footer {
            background: black;
            color: white;
            ;
            padding: 32px 40px;
            overflow: hidden
        }

        footer .social-lists {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            gap: 20px;
            text-align: center;
            width: max-content;
            margin: 0 auto;
            margin-bottom: 24px;
        }

        footer .social-lists li {
            display: inline-block;
            margin: 0px 6px;
        }

        footer .copyright {
            font-size: 18px;
            line-height: 1.22;
            margin-bottom: 24px
        }

        footer .footer-menu {
            text-align: center;
        }

        footer .footer-menu a {
            font-size: 16px;
            line-height: 1.5;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            color: white;
            margin-inline-end: 15px;
        }

        /* Tables */

        .table table {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            margin: 30px auto;
            width: 100%;
        }

        .table th {
            border-bottom: 1px solid #edeff2;
            margin: 0;
            padding-bottom: 8px;
        }

        .table td {
            color: #74787e;
            font-size: 15px;
            line-height: 18px;
            margin: 0;
            padding: 10px 0;
        }

        .content-cell {
            max-width: 100vw;
            padding: 32px;
        }

        /* Buttons */

        .action {
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
            margin: 30px auto;
            padding: 0;
            text-align: center;
            width: 100%;
        }

        .button {
            -webkit-text-size-adjust: none;
            color: #fff;
            background-color: #000;
            display: block;
            overflow: hidden;
            text-decoration: none;
            width: 100%;
            padding: 12px 25px;
            text-align: center;
            font-style: normal;
            border-radius: 3px;
            font-weight: 600;
            font-size: 16px;
            line-height: 24px;
        }

        .button-blue,
        .button-primary {
            background-color: #2d3748;
            background-color: #000;
        }

        .button-green,
        .button-success {
            background-color: #48bb78;
        }

        .button-red,
        .button-error {
            background-color: #e53e3e;
        }

        /* Panels */

        .panel {
            border-left: #2d3748 solid 4px;
            margin: 21px 0;
        }

        .panel-content {
            /* background-color: #edf2f7; */
            color: #718096;
            padding: 16px;
        }

        .panel-content p {
            color: #718096;
        }

        .panel-item {
            padding: 0;
        }

        .panel-item p:last-of-type {
            margin-bottom: 0;
            padding-bottom: 0;
        }

        /* Utilities */

        .break-all {
            word-break: break-all;
        }


        /* Custom class css */
        .temp-title {
            font-style: normal;
            font-weight: 600;
            font-size: 32px;
            line-height: 40px;
            color: #000000;
        }

        .temp-subtitle {
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 28px;
            color: #000000;
        }

        .temp-text {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 22px;
            color: #000000;
        }

        .order-summery,
        .order-info {
            padding: 32px 0px;
        }

        .order-summery h2,
        .account-info h2,
        .order-info h2 {
            font-style: normal;
            font-weight: 600;
            font-size: 24px;
            line-height: 32px;
            color: #000000;
            margin-bottom: 8px;
        }

        .order-summery p,
        .account-info p,
        .order-info p {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #000000;
            margin-bottom: 8px;
        }

        .order-summery table.body,
        .order-info table {
            border-collapse: separate;
            border-spacing: 0px 8px;
        }

        .order-summery table.body tr td,
        .order-info table tr td {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #000000;
        }

        .order-summery table.body tr td:last-child,
        .order-info table tr:not(:first-child) td:last-child {
            font-weight: 500;
        }

        .order-summery table.total,
        .order-info table tr:last-child {
            border-collapse: separate;
            border-spacing: 0px 16px;
            border-top: 1px solid #E0E0E0;
        }

        .order-info table tr:first-child {
            border-bottom: 2px solid #ddd;
        }

        .order-summery table.total tr td,
        .order-info table tr:last-child td {
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 28px;
            color: #000000;
        }

        .order-summery table.total tr td:last-child,
        .order-info table tr:last-child td:last-child {
            font-size: 20px;
            line-height: 28px;
        }

        .order-info table tr:first-child td {
            font-weight: 500;
        }

        .order-summery table tr td:last-child,
        .order-info table tr td:last-child {
            text-align: end;
        }

        .order-info table tr th {
            text-align: start;
        }

        .account-info p {
            margin-bottom: 20px;
        }

        .account-info .info-card h3 {
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            line-height: 17px;
            color: #000;
            margin-bottom: 8px;
        }

        .account-info .info-card p {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #000000;
            margin-bottom: 0px;
        }

        .account-info .info-card:not(:last-child) {
            margin-bottom: 20px;
        }

        .getting {
            padding: 24px;
            background: #F2F2F2;
        }

        .getting .title {
            font-weight: 600;
            font-size: 18px;
            line-height: 24px;
            color: #000000;
            margin-bottom: 12px;
        }

        .getting .description {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 22px;
            color: #000000;
            margin-bottom: 12px;
        }

        .getting .product-wrapper {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            gap: 16px;
        }

        .getting .product-wrapper img {
            width: 88px;
            height: 88px;
        }

        .getting .product-wrapper h3 {
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 22px;
            color: #000000;
        }

        .getting .product-wrapper p {
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 22px;
            color: #000000;
        }

        .cart-product .product-image {
            margin-inline-end: 16px;
        }

        .cart-product .product-image img {
            width: 88px;
            height: 88px;
            border-radius: 5px;
            border: 1px solid #dde0e3;
        }

        .cart-product {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .border-blue {
            border-color: #467fcf;
        }

        .bg-blue {
            background-color: #467fcf;
            color: #ffffff;
        }

        .bg-info {
            background-color: #929495 !important;
            color: #ffffff;
        }

        .btn {
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            font-weight: 600;
            font-size: 16px;
            padding: 12px 32px;
            border-radius: 3px;
            color: #ffffff;
            line-height: 100%;
            display: block;
            border: 1px solid transparent;
            -webkit-transition: .3s background-color;
            transition: .3s background-color;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
    <style>
        .gt a {
            display: inline-block !important;
            color: #222;
        }
    </style>
</head>

<body style="background: #f7fafc; width: 100%">
    <table style="width: 700px; margin: 0px auto; background: rgb(255, 255, 255);border:2px solid rgb(249, 248, 248)">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <table style="background: #000">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td style="width: 700px; height: 72px;">
                                    <center>
                                        <a href="{{ url('/') }}" style="margin-top: 7px;">
                                            <img src="https://scentq.com/images/logo.png" style="height:32px;"
                                                alt="">
                                        </a>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="padding:40px">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td>
                                    <table>
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-style: normal;font-weight: 600;color: #000000; font-size: 32px;line-height: 40px;">
                                                    Thank You for Your Order
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top:12px;font-style: normal;color: #000000; font-weight: 400;font-size: 16px;line-height: 22px;">
                                                    Now you can relax, We're working on getting your product to you
                                                    <span
                                                        style="font-style: normal;font-weight: 600;color: #000000; font-size: 16px;">ASAP!</span>
                                                    Be sure to add
                                                    products to your queue in the <span
                                                        style="font-style: normal;font-weight: 600;color: #000000; font-size: 16px;">next
                                                        12 hours</span> so we can work on shipping your them over to
                                                    you.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="width: 100%; margin-top:32px; background: #F2F2F2; padding:24px">
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3"
                                                    style="font-style: normal;font-weight: 600;color: #000000;font-size: 18px;line-height: 24px;">
                                                    What you’re getting...
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"
                                                    style="padding-top:12px; font-style: normal; color: #000000; font-weight: 400; font-size: 16px;line-height: 22px">
                                                    A month-to-month subscrition to Scentbird. Billed monthly, renews
                                                    automatically,
                                                    and ships
                                                    from our warehouse mid-month.
                                                </td>
                                            </tr>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td style="padding-top:12px;" colspan="1">
                                                        <img style="width: 80px; height:80px; object-fit: contain; display: flex !important; align-items:center !important"
                                                            src="{{ $item->product_image }}" alt="">
                                                    </td>
                                                    <td colspan="2"
                                                        style="padding-top:12px;font-style: normal;color: #000000;font-weight: 400;font-size: 16px; line-height: 22px; display: flex !important; align-items:center !important">
                                                        {!! $item->product_title !!}
                                                    </td>
                                                    <td colspan="1"
                                                        style="padding-top:12px;font-style: normal;font-weight: 600; white-space: nowrap; font-size: 16px; line-height: 22px;color: #000000; display: flex !important; align-items:center !important">
                                                        {{ currencyConvertWithSymbol($item?->amount) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table id="price" style="width: 100%; padding-top: 32px;">
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2"
                                                    style="font-style: normal;font-weight: 600;font-size: 24px; line-height: 32px;color: #000000;">
                                                    Order Summery
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"
                                                    style="font-style: normal;font-weight: 400;font-size: 16px; line-height: 24px;color: #000000;">
                                                    ORDER #{{ $order->order_no ?? $order->id }} From
                                                    {{ date('M d, Y H:i a', strtotime($order->created_at)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top: 16px; color: #000000;font-size: 16px; line-height: 24px;">
                                                    Subtotal (MONTHLY):
                                                </td>
                                                <td
                                                    style="padding-top: 16px; font-size: 16px; line-height: 24px; color: #000000; text-align:right">
                                                    {{ currencyConvertWithSymbol($order->net_total) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top: 16px;font-size: 16px; line-height: 24px; color: #000000;">
                                                    Coupon: {{ $coupon?->amount }}% Off
                                                </td>
                                                <td
                                                    style="padding-top: 16px; font-size: 16px; line-height: 24px; color: #000000; text-align:right">
                                                    @if ($coupon)
                                                        @if ($coupon->discount_type == 1)
                                                            {{ currencyConvertWithSymbol(($coupon->amount / 100) * $order->net_total) }}
                                                        @else
                                                            {{ currencyConvertWithSymbol($coupon->amount) }}
                                                        @endif
                                                    @else
                                                        - {{ currencyConvertWithSymbol(0.0) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top: 16px; font-size: 16px; line-height: 24px; color: #000000;">
                                                    Shipping:
                                                </td>
                                                <td style="padding-top: 16px; text-align:right; font-size: 16px;">
                                                    {{ currencyConvertWithSymbol($order->shipping_cost) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 16px;" colspan="2">
                                                    <hr style="1px solid #E0E0E0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top: 16px; font-style: normal;font-weight: 600;font-size: 18px;line-height: 28px;color: #000000;">
                                                    Total:
                                                </td>
                                                <td
                                                    style="padding-top: 16px; font-style: normal;font-weight: 600;font-size: 18px;text-align:right;line-height: 28px;color: #000000;">
                                                    {{ currencyConvertWithSymbol($order->gross_total) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding-top:32px; font-style: normal;font-weight: 600;font-size: 24px;line-height: 32px;color: #000000;">
                                                    Your Order Info
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-style: normal;font-weight: 400;font-size: 16px;line-height: 24px;color: #000000;">
                                                    ORDER #{{ $order->id }} From
                                                    {{ date('M d, Y H:i a', strtotime($order->created_at)) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding-top:20px; font-style: normal;font-weight: 600;font-size: 14px;line-height: 17px;color: #FF000;">
                                                    Shipping To:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top:8px;font-style: normal;font-weight: 400;font-size: 16px; line-height: 24px;color: #000000;">
                                                    {{-- ORXAN RASULOV <br>
                                                    320 CORNELL DR <br>
                                                    A160943 CAMEX LLCWILMINGTON, DE, 19801-5783US --}}
                                                    @foreach ($order->addresses as $shipping)
                                                        {{ $shipping->name }} <br>
                                                        {{ $shipping->line1 }}{{ $shipping->line2 }},
                                                        {{ $shipping->city }}- <br>
                                                        {{ $shipping->postal_code }},
                                                        {{ $shipping->country }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="padding-top:20px; font-style: normal;font-weight: 600;font-size: 14px;line-height: 17px;color: #000;">
                                                    Billed to:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top:8px; font-style: normal;font-weight: 400;font-size: 16px; line-height: 24px;color: #000000;">
                                                    {{-- ORXAN RASULOV <br>
                                                    320 CORNELL DR <br>
                                                    A160943 CAMEX LLCWILMINGTON, DE, 19801-5783US --}}
                                                    @foreach ($order->payments as $payment)
                                                        ${{ $order->net_total }} |
                                                        {{ $payment->created_at->format('M d, Y') }}
                                                        <br>
                                                        {{ strtoupper($payment->data['brand']) }}
                                                        - {{ $payment->data['last4'] }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-style: normal;font-weight: 600;font-size: 14px;line-height: 17px;color: #000;">
                                                    Payment Method:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding-top: 8px; padding-botton: 8px;font-style: normal;font-weight: 400;font-size: 16px;line-height: 24px;color: #000000;">
                                                    {{ $order->payments[0]['payment_method_name'] }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <main>
                                            <div class="content">
                                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td class="content-cell">
                                                                        <h2 class="temp-title">
                                                                            Thank You for Your Order
                                                                        </h2>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td class="content-cell">
                                                                        <strong style="margin-bottom: 10px; display: block; font-size: 18px">Hello
                                                                            {{ $order->user->first_name }}, Your order has been successfully
                                                                            placed.</strong>
                                                                        <p class="temp-text">
                                                                            Thanks for your order! Be sure to add products to your queue in the next 12
                                                                            hours so we can work on shipping your them over to you.
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                                <tr>
                                                                    <td>
                                                                        <div class="order-info" style="padding:0 20px 0 20px">
                                                                            <table width="100%" cellpadding="0" cellspacing="0" class="body">
                                                                                <tr>
                                                                                    <th>
                                                                                        Product
                                                                                    </th>
                                                                                    <th>
                                                                                        Qty
                                                                                    </th>
                                                                                    <th style="text-align: end;">
                                                                                        Price
                                                                                    </th>
                                                                                </tr>
                                                                                @foreach ($order->items as $item)
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="cart-product">
                                                                                                <div class="product-image">
                                                                                                    <img src="{{ $item->product_image }}"
                                                                                                        alt="">
                                                                                                </div>
                                                                                                <div>
                                                                                                    <strong>{{ $item->product_title }}</strong>
                                                                                                    <p>0.27 oz vial</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ $item->quantity }}
                                                                                        </td>
                                                                                        <td>
                                                                                            ${{ $item->amount }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                <tr>
                                                                                    <td>
                                                                                    </td>
                                                                                    <td>
                                                                                        Total
                                                                                    </td>
                                                                                    <td>
                                                                                        ${{ $order->net_total }}
                                                                                    </td>
                                                                                </tr>
                                                                            </table>


                                                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                                                <tr>
                                                                                    <td>
                                                                                        <table width="100%" cellpadding="0" cellspacing="0"
                                                                                            role="presentation">
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <div class="account-info content-cell">
                                                                                                        <h2>Your Account Info</h2>
                                                                                                        <p>ORDER #{{ $order->id }} From
                                                                                                            {{ $order->created_at->format('M d, Y H:i a') }}
                                                                                                        </p>

                                                                                                        <div class="info-card">
                                                                                                            <h3>Shipping To:</h3>
                                                                                                            @foreach ($order->addresses as $shipping)
                                                                                                                <div>
                                                                                                                    <p>{{ $shipping->name }}</p>
                                                                                                                    <p>{{ $shipping->line1 }}{{ $shipping->line2 }},
                                                                                                                    </p>
                                                                                                                    <p>{{ $shipping->city }}-
                                                                                                                        {{ $shipping->postal_code }},
                                                                                                                        {{ $shipping->country }}</p>
                                                                                                                </div>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                        <div class="info-card">
                                                                                                            <h3>Billed to:</h3>
                                                                                                            @foreach ($order->payments as $payment)
                                                                                                                <p>${{ $order->net_total }} |
                                                                                                                    {{ $payment->created_at->format('M d, Y') }}
                                                                                                                </p>
                                                                                                                <p>{{ strtoupper($payment->data['brand']) }}
                                                                                                                    - {{ $payment->data['last4'] }}</p>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                        <div class="info-card">
                                                                                                            <h3>Payment Method:</h3>
                                                                                                            <div>
                                                                                                                <p>{{ $order->payments[0]['payment_method_name'] }}
                                                                                                                </p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="info-card">
                                                                                                            <h3>Purchase Type:</h3>
                                                                                                            <div>
                                                                                                                <p>{{ $order->queue_id ? 'Subscription' : 'One-Time' }}
                                                                                                                </p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </main>
                                        --}}
                    <table style="width: 100%; background: rgb(0, 0, 0); padding-top: 25px;">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center">
                                    @foreach ($social_media as $key => $media)
                                        <a href="{{ $media->link }}" style="padding-left: 10px; color: white;">
                                            <img src="{{ $media->icon_url }}" alt="{{ $media->name }}"
                                                style="width: 24px; height: 24px;" />
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:10px; text-align:center; color:white"
                                    colspan="{{ count($social_media) }}">
                                    &copy; scentQ {{ date('Y') }}.
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:30px; padding-top:30px; text-align:center; color:white"
                                    colspan="{{ count($social_media) }}">
                                    <a style="color:white; padding-left:30px;" style="color: white;"
                                        href="{{ route('page', 'privacy-policy') }}">
                                        Privacy Policy
                                    </a>
                                    <a style="color:white; padding-left:30px;" style="color: white;"
                                        href="{{ route('page', 'terms-and-conditions') }}">
                                        Refund Policy
                                    </a>
                                    <a style="color:white; padding-left:30px;" style="color: white;"
                                        href="{{ route('page', 'terms-and-conditions') }}">
                                        Terms And Conditions
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {{-- <footer style="padding-top: 25px;">
                        <ul class="social-lists">
                            @foreach ($social_media as $key => $media)
                                <li>
                                    <a href="{{ $media }}" style="color: white;">
                                        <img src="{{ 'https://scentq.com/social-icons/' . $key . '.png' }}"
                                            alt="{{ $key }}" style="width: 24px; height: 24px;" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <p class="copyright"></p>
                        <div class="footer-menu">
                        </div>
                    </footer> --}}
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
