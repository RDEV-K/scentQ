<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\MailSubscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MailSubscriber::query()->latest();
            $table = datatables($query);
            $table->editColumn('id', function ($staff) {
                return $staff->id;
            });
            $table->editColumn('email', function ($staff) {
                return $staff->email;
            });
            $table->addColumn('action', function ($staff) {
                return '<button class="btn btn-danger btn-delete btn-sm ml-1" data-id="' . $staff->id . '"><i
                                                class="fas fa-trash"></i></button>';
            });
            $table->rawColumns(['id', 'email', 'action']);
            return $table->make(true);
        }
        return view('staff.subscriber.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email = MailSubscriber::FindOrFail($id);

        if (!$email) return abort(404);
        $res = $email->delete();

        if (!$res) return redirect()->back()->withErrors(__('Email not deleted. May be one or more data exists'));

        return redirect()->back()->withSuccess(__('Email deleted successfully'));
    }
}
