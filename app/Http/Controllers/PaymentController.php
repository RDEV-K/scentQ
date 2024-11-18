<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Staff;
use App\Models\Gateway;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Events\PaymentReceived;
use App\Notifications\Admin\NewOrderNotification;

class PaymentController extends Controller
{
    static function order(Order $order, $gatewayId, $data = [])
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
        return self::process($payment, $data);
    }

    static function queueOrder(Order $order)
    {
        $gateway = Gateway::findOrFail(1);
        $payment = Payment::create([
            'holder_type' => Order::class,
            'holder_id' => $order->id,
            'payment_method_name' => $gateway->name,
            'gateway_id' => $gateway->id,
            'title' => 'Order ' . str_pad($order->order_no ?? $order->id, 6, "0", STR_PAD_LEFT),
            'amount' => 0,
        ]);
        $payment->update([
            'status' => Payment::$STATUS_SUCCESS
        ]);
        event(new PaymentReceived($payment));
    }

    static function process(Payment $payment, $data = [])
    {
        if ($payment->amount <= 0) {
            $payment->update([
                'status' => Payment::$STATUS_SUCCESS
            ]);
            event(new PaymentReceived($payment));
            return redirect()->route('payment.success', encrypt($payment->id));
        }
        $processor = self::getPaymentProcessor($payment);
        return $processor->process($payment, $data);
    }

    private static function getPaymentProcessor(Payment $payment)
    {
        $processor_class = 'App\\PaymentMethods\\' . $payment->gateway->class_name;
        return new $processor_class;
    }

    function ipnReceiver(Request $request, $ref)
    {
        $payment = Payment::findOrFail(decrypt($ref));
        $processor = self::getPaymentProcessor($payment);
        return $processor->ipn($request, $payment);
    }

    function successPayment($ref)
    {
        $payment = Payment::findOrFail(decrypt($ref));
        $payment->update([
            'status' => Payment::$STATUS_SUCCESS
        ]);
        // $message = sprintf(__('Your payment of %s %s has received successfully'), $payment->amount, config('misc.currency_code'));

        $message = sprintf(__('Your order has placed successfully'));

        if ($payment->holder_type == 'App\Models\Order' && $payment->holder_id) {
            return redirect(route("order.track", $payment->holder_id))->with(["success" => $message]);
        } else {
            return redirect(route("order"))->with(["success" => $message]);
        }
    }

    function failedPayment($ref)
    {
        $payment = Payment::findOrFail(decrypt($ref));

        $payment->update([
            'status' => Payment::$STATUS_FAILED
        ]);

        $message = sprintf(__('Your payment of %s %s has failed. Try again and put in the correct payment information'), $payment->amount, config('misc.currency_code'));

        session()->flash('warning_alert', $message);
        return redirect()->back();
    }
}
