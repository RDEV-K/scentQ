<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Staff;
use App\Notifications\Admin\NewOrderNotification;
use App\Events\PaymentReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionPaymentController extends Controller
{
    static function order(Order $order, $gatewayId, $data = [],$paymentMethod,$transactionId)
    {
        $gateway = Gateway::findOrFail($gatewayId);
        $payment = Payment::create([
            'holder_type' => Order::class,
            'holder_id' => $order->id,
            'payment_method_name' => $gateway->name,
            'gateway_id' => $gatewayId,
            'title' => 'Order ' . str_pad($order->id, 6, "0", STR_PAD_LEFT),
            'amount' => currencyConvert($order->gross_total) ?? $order->gross_total,
            'curreny' => config('misc.currency_code'),
            'usd_price' => $order->gross_total ?? 0,
        ]);

        if (checkMailConfig()) {
            $staffs = Staff::all();
            foreach ($staffs as $key => $staff) {
                $staff->notify(new NewOrderNotification($order));
            }
        }
        return self::process($payment, $data,$paymentMethod,$transactionId);
    }

    static function process(Payment $payment, $data = [],$paymentMethod,$transactionId)
    {
        if ($payment->amount <= 0) {
            $payment->update([
                'status' => Payment::$STATUS_SUCCESS
            ]);
            event(new PaymentReceived($payment));
            return redirect()->route('payment.success', encrypt($payment->id));
        }

        return self::getPaymentProcessor($payment, $data,$paymentMethod,$transactionId);
    }

    static function getPaymentProcessor(Payment $payment, $data = [],$paymentMethod,$transactionId)
    {
        /* @var User $user */
        $user = \request()->user('web');
        if (isset($data['payment_method'])) {
            try {

                $method = $user->findPaymentMethod($paymentMethod)->asStripePaymentMethod();
                $payment->update([
                    'status' => Payment::$STATUS_SUCCESS,
                    'transaction_id' => $transactionId,
                    'data' => $method->card
                ]);
                event(new PaymentReceived($payment));

                $message = sprintf(__('Your order has placed successfully'));

                if ($payment->holder_type == 'App\Models\Order' && $payment->holder_id) {
                    return redirect(route("order.track", $payment->holder_id))->with(["success" => $message]);
                } else {
                    return redirect(route("order"))->with(["success" => $message]);
                }
            } catch (\Exception $exception) {
                Log::error($exception->getMessage(), ['payment_id' => $payment->id]);
                Log::error($exception->getTraceAsString(), ['payment_id' => $payment->id]);
                return redirect()->route('payment.failed', encrypt($payment->id))->withErrors('Payment Failed');
            }
        }
    }
}
