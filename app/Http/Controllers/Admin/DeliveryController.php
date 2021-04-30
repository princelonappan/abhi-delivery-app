<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;

class DeliveryController extends Controller
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
        $delivery_charge = Settings::where('slug', 'delivery_charge')->first();
        return view('admin.delivery_charge.create', compact('delivery_charge'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'min_amount' => 'required'
        ]);
        $delivery_charge = Settings::where('slug', 'delivery_charge')->first();
        if(!empty($delivery_charge)) {
            $delivery_charge->amount = $request->amount;
            $delivery_charge->min_amount = $request->min_amount;
            $delivery_charge->type = 1;
            $delivery_charge->slug = 'delivery_charge';
            $delivery_charge->save();
        } else {
            $delivery_charge = new Settings();
            $delivery_charge->amount = $request->amount;
            $delivery_charge->min_amount = $request->min_amount;
            $delivery_charge->type = 1;
            $delivery_charge->slug = 'delivery_charge';
            $delivery_charge->save();
        }
        return redirect('/admin/delivery-charge/create')->with('success', 'Vat % Successfully Updated!');
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
