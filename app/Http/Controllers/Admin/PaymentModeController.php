<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;

class PaymentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_mode = Settings::where('slug', 'payment_mode')->first();
        return view('admin.payment_mode.create', compact('payment_mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_mode = Settings::where('slug', 'payment_mode')->first();
        if(!empty($payment_mode)) {
            $payment_mode->cash_on_delivery = $request->cash_on_delivery == 1 ? 1 : 0;
            $payment_mode->card_payment = $request->card_payment == 1 ? 1 : 0;
            $payment_mode->slug = 'payment_mode';
            $payment_mode->save();
        } else {
            $payment_mode = new Settings();
            $payment_mode->cash_on_delivery = $request->cash_on_delivery == 1 ? 1 : 0;
            $payment_mode->card_payment = $request->card_payment == 1 ? 1 : 0;
            $payment_mode->slug = 'payment_mode';
            $payment_mode->save();
        }
        return redirect('/admin/payment-mode/create')->with('success', 'Payment Mode Successfully Updated!');
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
        //
    }
}
