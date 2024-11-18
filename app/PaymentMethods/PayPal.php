<?php

namespace App\PaymentMethods;

use App\Events\PaymentReceived;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayPal
{
    public function process(Payment $payment, $data = [])
    {
        $paypalUrl = $payment->gateway->test_mode ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://paypal.com/cgi-bin/webscr';
        $params = [
            'cmd' => '_xclick',
            'business' => $payment->gateway->credentials['business_email'],
            'cbt' => config('app.name'),
            'currency_code' => config('misc.currency_code'),
            'quantity' => 1,
            'item_name' => $payment->title,
            'custom' => $payment->id,
            'amount' => $payment->amount,
            'return' => route('payment.success', encrypt($payment->id)),
            'cancel_return' => route('payment.failed', encrypt($payment->id)),
            'notify_url' => route('payment.ipn', encrypt($payment->id)),
        ];
        return Inertia::location($paypalUrl . '?' . http_build_query($params));
    }

    public function ipn(Request $request, Payment $payment)
    {
        $raw_post_data = $request->getContent();
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }


        $paypalURL = $payment->gateway->test_mode ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://paypal.com/cgi-bin/webscr";
        $ch = curl_init($paypalURL);
        if ($ch == FALSE) {
            return FALSE;
        }
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: Scentq'));
        $res = curl_exec($ch);
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));

        if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {
            $receiver_email = $request->receiver_email;
            $mc_currency = $request->mc_currency;
            $mc_gross = $request->mc_gross;
            if (
                $mc_currency == config('misc.currency_code') &&
                $mc_gross >= $payment->amount &&
                $receiver_email == $payment->gateway->credentials['business_email'] &&
                $payment->status == Payment::$STATUS_PENDING
            ) {
                $r = $payment->update([
                    'status' => Payment::$STATUS_SUCCESS,
                    'transaction_id' => $request->txn_id
                ]);
                if (!$r) throw new \Exception('Payment not updated. TXN ID ' . $request->txn_id);
                event(new PaymentReceived($payment));
            }
        }
    }
}
