@component('mail::message')
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<h2 class="temp-title">
Yeni Sifariş Emal üçün Hazırdır!
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
<strong style="margin-bottom: 10px; display: block; font-size: 18px">Salam
{{ $order->user->name }}, Yeni Sifarişiniz emal olunur: İndi hərəkət edin.</strong>
<p class="temp-text">
Səmərəliliyi Artırın və Müştəri Tələblərinə cavab verin: Maraqlı Yeni SifaEnhance Efficiency
and Meet Customer Demands: Seamlessly Process and Fulfill the Exciting New Order!rişi
Sorunsuz Proses və Yerinə yetirin!
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
<div class="order-info">
<table width="100%" cellpadding="0" cellspacing="0" class="body">
<tr>
<th>
Məhsul
</th>
<th>
kəmiyyət
</th>
<th style="text-align: end;">
Price
</th>
</tr>
@foreach ($order->items as $item)
<tr>
<td style="padding-bottom: 10px;">
<div class="cart-product"
style="display: flex !important; align-items:center !important">
<div class="">
<img style="width: 80px; height:80px; object-fit:cover; margin-right: 8px;"
src="{{ $item->product_image }}" alt="">
</div>
<div>
<strong>{{ $item->product_title }}</strong>
<p style="margin-bottom: 0px;">0.34 oz vial</p>
</div>
</div>
</td>
<td style="padding-bottom: 10px;">
{{ $item->quantity }}
</td>
<td style="padding-bottom: 10px;">
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
<h2>Sifariş Məlumatı</h2>
<p>SİFARİŞ #{{ $order->order_no ?? $order->id }} From
{{ $order->created_at->format('M d, Y H:i a') }}</p>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
@component('mail::button', ['url' => route('staff.order.show', $order->id)])
Sifarişə Baxın
@endcomponent
@endcomponent
