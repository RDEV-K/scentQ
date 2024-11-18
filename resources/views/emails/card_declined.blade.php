@extends('emails.template.layout')
@section('content')
    <table style="width: 100%; padding: 32px 40px; background-color: white;">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <h2 style="font-weight: 600;font-size: 32px;line-height: 40px;color: #000000; margin-bottom:12px;">
                        Hey {{ $user->first_name }} {{ $user->last_name }},
                    </h2>
                    <h3
                        style="font-weight: 600; font-size: 24px; line-height: 28px; color: #000000;margin-bottom: 12px; margin-top: 11px;">
                        Your card has been declined!
                    </h3>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-family:sans-serif;font-weight: 400;font-size: 16px;line-height: 22px; color: #000000;">
                        We regret to inform you that there has been an issue with the processing of
                        your recent payment using your card.
                        Unfortunately, the transaction was declined for the following reason:
                    </p>
                    <h4 style="font-family:sans-serif;">
                        Reason: Card Declined
                    </h4>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
