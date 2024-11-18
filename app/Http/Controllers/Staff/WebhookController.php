<?php

namespace App\Http\Controllers\Staff;

// use App\Models\WebhookCall;
use App\Models\WebhookCall;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\StripeWebhooks\InvoicePaymentSucceededJob;
use Spatie\WebhookClient\Models\WebhookCall as WebhookCallMain;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        $data = WebhookCall::query()->latest()->paginate(20);
        return view('staff.webhook.index', compact('data'));
    }

    public function update(Request $request, WebhookCallMain $webhook)
    {
        try {
            InvoicePaymentSucceededJob::dispatch($webhook);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

        return redirect()->back();
    }
}
