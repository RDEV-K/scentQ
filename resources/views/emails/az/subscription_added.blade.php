@component('mail::message')
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom: 12px;">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<h2 class="temp-title">
Abunəliyiniz uğurla əlavə edildi!
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
<div class="account-info">
<h2 style="font-size: 24px; line-height: 32px; font-weight: 500;">Plan məlumatınız</h2>
<table style="width: 100%; padding: 20px; background: #F2F2F2;">
<tr>
<td style="font-size: 16px; line-height: 24px; color: #000;">Plan:</td>
<td style="font-size: 16px; line-height: 24px; color: #000; font-weight: 500;">{{ $plan->name }}</td>
</tr>
<tr>
<td style="font-size: 16px; line-height: 24px; color: #000;">Qiymət:</td>
<td style="font-size: 16px; line-height: 24px; color: #000; font-weight: 500;">{{ currencyConvertWithSymbol($plan->total_price) }}</td>
</tr>
<tr>
<td style="font-size: 16px; line-height: 24px; color: #000;">Aylıq Məhsul:</td>
<td style="font-size: 16px; line-height: 24px; color: #000; font-weight: 500;">{{ $plan->product_count }}</td>
</tr>
</table>
<br>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
