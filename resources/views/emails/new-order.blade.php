@component('mail::message')
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td>
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
                        <td>
                            {{-- <p class="temt-text" style="margin-bottom: 32px">
Now you can relax, We're working on getting your product to you ASAP! Be sure to add products to your queue in the next 12 hours so we can work on shipping your them over to you.
</p> --}}
                            <strong style="margin-bottom: 10px; display: block; font-size: 18px">Hello
                                {{ $order->user->first_name }}, Your order has been successfully placed.</strong>
                            <p class="temp-text">
                                Thanks for your order! Be sure to add products to your queue in the next 12 hours so we can
                                work on shipping your them over to you.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<div class='getting'>
<h2 class="title">What you’re getting...</h2>
<p class="description">A month-to-month subscrition to Scentbird. Billed monthly, renews automatically, and ships from our warehouse mid-month.</p>
<div class="product-wrapper">
<img src="https://cdn.pixabay.com/photo/2014/02/27/16/10/flowers-276014__340.jpg" alt="">
<h3>Your choice of one fragrance a month, with a free case included</h3>
<p>$16.95</p>
</div>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table> --}}


    {{-- <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<div class="order-summery">
<h2>Order Summery</h2>
<p>ORDER #2029060 From December 19, 2022 09:38:29 AM EST</p>
<table width="100%" cellpadding="0" cellspacing="0" class="body">
<tr>
<td>
Subtotal (MONTHLY):
</td>
<td>
$8.47
</td>
</tr>
<tr>
<td>
Tax:
</td>
<td>
$0.00
</td>
</tr>
<tr>
<td>
Coupon:
</td>
<td>
-$0.00
</td>
</tr>
<tr>
<td>
Shipping:
</td>
<td>
$20.00
</td>
</tr>
<tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="total">
<tr>
<td>
Total
</td>
<td>
$8.47
</td>
</tr>
</table>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table> --}}

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td>
                            <div class="order-info">
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
                                            <td
                                                style="margin-bottom: 10px; display: flex !important; align-items:center !important">
                                                <table class="cart-product"
                                                    style="display: flex !important; align-items:center !important">
                                                    <tr>
                                                        <td>
                                                            <img style="width: 80px; height:80px; object-fit: contain;"
                                                                src="{{ $item->product_image }}" alt="">
                                                        </td>
                                                        <td>
                                                            <strong>{{ $item->product_title }}</strong>
                                                            <p style="margin-bottom: 0px;">0.34 oz vial</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="margin-bottom: 10px;">
                                                {{ $item->quantity }}
                                            </td>
                                            <td style="margin-bottom: 10px;">
                                                {{ currencyConvertWithSymbol($item->amount) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            Discount
                                        </td>
                                        <td>
                                            @if ($order->coupon)
                                                @if ($order->coupon->discount_type == 1)
                                                    - {{ $order->discount }}% =
                                                    {{ currencyConvertWithSymbol(($order->discount / 100) * $order->net_total) }}
                                                @else
                                                    - {{ currencyConvertWithSymbol($order->discount) }}
                                                @endif
                                            @else
                                                - {{ currencyConvertWithSymbol($order->discount) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            Shipping
                                        </td>
                                        <td>
                                            {{ currencyConvertWithSymbol($order->shipping_cost) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            Total
                                        </td>
                                        <td>
                                            {{ currencyConvertWithSymbol($order->gross_total) }}
                                        </td>
                                    </tr>
                                </table>


                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td>
                                                        <div class="account-info">
                                                            <h2>Your Order Info</h2>
                                                            <p>ORDER #{{ $order->order_no ?? $order->id }} From
                                                                {{ $order->created_at->format('M d, Y H:i a') }}</p>

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
                                                                    <p>{{ currencyConvertWithSymbol($order->net_total) }} |
                                                                        {{ $payment->created_at->format('M d, Y') }}</p>
                                                                    <p>{{ strtoupper($payment->data['brand']) }} -
                                                                        {{ $payment->data['last4'] }}</p>
                                                                @endforeach
                                                            </div>
                                                            <div class="info-card">
                                                                <h3>Payment Method:</h3>
                                                                <div>
                                                                    <p>{{ $order->payments[0]['payment_method_name'] }}</p>
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


                                @component('mail::button', ['url' => route('order.invoice', [$order->id, 'pdf'])])
                                    Download Invoice
                                @endcomponent


                                Thanks,<br>
                                {{ config('app.name') }}
                            @endcomponent
