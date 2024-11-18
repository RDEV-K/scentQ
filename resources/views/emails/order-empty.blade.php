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
<strong style="margin-bottom: 10px; display: block; font-size: 18px">Hello {{ $name }}, Your order has been received successfully.</strong>
<p class="temp-text">
However, we want to inform you that there are no products associated with your order. <br>
Please ensure that you have added the desired products to your queue. <br>
If not, we will be added automatically after 48 hours from the creation date of your order.
</p>
</td>
</tr>
</table>
</td>
</tr>
</table>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
