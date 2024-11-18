@component('mail::message')
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<h2 class="temp-title">
Sifarişiniz üçün təşəkkür edirik
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
Bununla belə, sizə bildirmək istəyirik ki, sifarişinizlə əlaqəli heç bir məhsul yoxdur. <br>
İstədiyiniz məhsulları növbənizə əlavə etdiyinizə əmin olun. <br>
Əks təqdirdə, sifarişinizin yaradıldığı tarixdən 48 saat sonra avtomatik olaraq əlavə olunacaq.
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
