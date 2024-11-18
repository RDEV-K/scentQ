<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gateways = Gateway::all();
        return view('staff.gateway.index', compact('gateways'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'gateway' => 'required|array',
            'gateway.*' => 'required|array',
            'gateway.*.name' => 'required|string|max:191',
            'gateway.*.credentials' => 'required|array',
            'gateway.*.image' => 'nullable',
            'gateway.*.test_mode' => 'nullable|in:1,0',
        ]);
        try {
            DB::beginTransaction();
            foreach ($request->gateway as $gateway_id => $gateway) {
                $p = Arr::only($gateway, ['name', 'credentials', 'image']);
                if (isset($gateway['test_mode'])) {
                    $p['test_mode'] = 1;
                } else {
                    $p['test_mode'] = 0;
                }
                Gateway::query()->where('id', $gateway_id)->update($p);
            }

            // Replace stripe webhook
            $this->envReplace('STRIPE_WEBHOOK_SECRET', $request->stripe_webhook);

            DB::commit();
            return redirect()->back()->withSuccess(__('Updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['gateway' => $exception->getMessage()]);
        }
    }

    protected function envReplace($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name.'='.env($name),
                $name.'='.$value,
                file_get_contents($path)
            ));
        }

        if (file_exists(\App::getCachedConfigPath())) {
            \Artisan::call('config:cache');
        }
    }
}

