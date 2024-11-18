<?php

namespace App\Http\Controllers\Staff;

use App\Models\QueuePurchasePolicy;
use Illuminate\Http\Request;

class QueuePurchasePolicyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = QueuePurchasePolicy::query();
            $table = datatables($query);
            $table->addColumn('action', function (QueuePurchasePolicy $queue) {
                return '<div class="d-flex">
                            <button class="btn btn-warning btn-edit btn-sm"
                                data-id="'. $queue->id .'"
                                data-minimum_count="'. $queue->minimum_count .'"
                                data-maximum_count="'. $queue->maximum_count .'"
                                data-discount="'. $queue->discount .'"
                            >
                            <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn btn-danger btn-delete btn-sm ml-1"
                                data-id="' . $queue->id . '"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->editColumn('discount', function (QueuePurchasePolicy $queue) {
                return '<span class="badge badge-primary text-light">'.currencyConvertWithSymbol($queue->discount).'</span>';
            });
            $table->rawColumns(['action', 'discount']);
            return $table->make(true);
        }
        return view('staff.queuePurchase.queue-purchases');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'minimum_count' => 'required|numeric',
            'maximum_count' => 'required|numeric',
            'discount' => 'required|numeric'
        ]);
        $param = $request->only(['minimum_count', 'maximum_count', 'discount']);
        $res = QueuePurchasePolicy::create($param);
        if (!$res) return redirect()->back()->withInput()->withErrors('Unable to create Queue Purchase Policy');
        return redirect()->back()->withSuccess('Queue Purchase Policy created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QueuePurchasePolicy  $queuePurchasePolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $queuePurchase)
    {
        $queuePurchase = QueuePurchasePolicy::findOrFail($queuePurchase);
        if (!$queuePurchase) return abort(404);
        $request->validate([
            'minimum_count' => 'required|numeric',
            'maximum_count' => 'required|numeric',
            'discount' => 'required|numeric'
        ]);
        $param = $request->only(['minimum_count', 'maximum_count', 'discount']);
        $res = $queuePurchase->update($param);
        if (!$res) return redirect()->back()->withErrors('Unable to Update Queue Purchase Policy');
        return redirect()->back()->withSuccess('Queue Purchase Policy Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QueuePurchasePolicy  $queuePurchasePolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy($queuePurchase)
    {
        $queuePurchase = QueuePurchasePolicy::findOrFail($queuePurchase);
        if (!$queuePurchase) return abort(404);
        $res = $queuePurchase->delete();
        if (!$res) return redirect()->back()->withErrors(__('Unable to delete This Queue Purchase Policy'));
        return redirect()->back()->withSuccess(__('Queue Purchase Policy deleted successfully'));
    }
}
