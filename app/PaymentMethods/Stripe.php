<?php

namespace App\PaymentMethods;

use App\Events\PaymentReceived;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

class Stripe
{
    /**
     * @throws \Laravel\Cashier\Exceptions\IncompletePayment
     */
    function process(Payment $payment, $data = [])
    {
        /* @var User $user */
        $user = \request()->user('web');
        if (isset($data['payment_method'])) {
            try {
                $stripePayment = $this->makeCharge($payment, $data);
                $intent = $stripePayment->asStripePaymentIntent();
                $method = $user->findPaymentMethod($data['payment_method'])->asStripePaymentMethod();
                $payment->update([
                    'status' => Payment::$STATUS_SUCCESS,
                    'transaction_id' => $intent->id,
                    'data' => $method->card
                ]);
                event(new PaymentReceived($payment));
                return redirect()->route('payment.success', encrypt($payment->id));
            } catch (\Exception $exception) {
                Log::error($exception->getMessage(), ['payment_id' => $payment->id]);
                Log::error($exception->getTraceAsString(), ['payment_id' => $payment->id]);
                return redirect()->route('payment.failed', encrypt($payment->id))->withErrors('Payment Failed');
            }
        }
        // TODO: Add Abandoned Order Payment
    }

    /**
     * @throws \Laravel\Cashier\Exceptions\IncompletePayment
     * @throws \Exception
     */
    private function makeCharge(Payment $payment, $data = []): \Laravel\Cashier\Payment
    {
        if (!isset($data['payment_method'])) throw new \Exception('Payment Method Missing');
        /* @var User $user */
        $user = \request()->user('web');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($data['payment_method']);
        return $user->charge($payment->amount*100, $data['payment_method'], ['off_session' => true, 'description' => $payment->title]);
    }

    public function ipn(Request $request, Payment $payment)
    {
        $stripe_session_ = $payment->metas()->where('name', 'stripe_session')->first();
        if (!$stripe_session_) return redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track, 'token' => request()->get('token')]);
        \Stripe\Stripe::setApiKey($dbMethod->cred2);
        try {
            $checkout_session = Session::retrieve($stripe_session_->content);
        } catch (\Exception $exception) {
            return redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track, 'token' => request()->get('token')])->withErrors($exception->getMessage());
        }
        if (!$checkout_session) redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track, 'token' => request()->get('token')])->withErrors('Transaction has been failed!');
        try {
            $intent = PaymentIntent::retrieve($checkout_session->payment_intent);
        } catch (ApiErrorException $e) {
            return redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track, 'token' => request()->get('token')])->withErrors($e->getMessage());
        }
        if (!$intent) return redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track, 'token' => request()->get('token')])->withErrors('Unable to fetch the transaction details!');
        if ($intent->status != 'succeeded') redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track, 'token' => request()->get('token')])->withErrors('Transaction has been failed!');
        DB::beginTransaction();
        try {
            $payment->update([
                'status' => 1,
                'transaction_id' => $intent->id
            ]);
            $payment->order->update([
                'status' => 0
            ]);
            $payment->order->addNote('Payment received via Stripe. TXN ID ' . $intent->id);
            event(new OrderPaymentConfirmed($payment));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->route('payment.failed', ['type' => 'order', 'ref' => $payment->track])->withErrors($exception->getMessage());
        }
        DB::commit();
        return redirect()->route('payment.success', ['type' => 'order', 'ref' => $payment->track])->withSuccess('Payment successfully completed');
    }
}
