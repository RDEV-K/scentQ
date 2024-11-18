@extends('emails.template.layout')
@section('content')
    <section style="padding: 32px 40px; background-color: white;">
        <h2 style="font-weight: 600;font-size: 32px;line-height: 40px;color: #000000; margin-bottom:12px;">
            Hey {{Zafor}}, Please Update Your Payment Info
        </h2>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
            Your most recent payment couldn’t be processed. This may be due to a change in card number, expiration or cancellation or even because your bank didn’t recognize the payment.
        </p>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
            In order to receive this month’s fragrance, <a href="#" style="color: black; text-decoration: underline">please update your payment information.
            </a>
        </p>
        <p style="font-weight: 400;font-size: 16px;line-height: 22px; color: #000000; margin-bottom: 32px;">
            We’ll re-attempt the charge and will let you know if we experience any issues billing your selected payment method.</p>
        <a href="#" style="width: 100%; display: flex; justify-content:center; align-items: center; padding: 16px 40px;width: 520px;height: 56px;background: #000000;border: 2px solid #000000; font-weight: 600;font-size: 16px;line-height: 24px;text-align: center;text-transform: uppercase; color: #FFFFFF;">
            Update now
        </a>
    </section>
@endsection
