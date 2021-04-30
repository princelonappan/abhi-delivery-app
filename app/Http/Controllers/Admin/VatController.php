<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Settings;

class VatController extends Controller
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
        $vat = Settings::where('slug', 'vat')->first();
        return view('admin.vat.vat', compact('vat'));
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
            'amount' => 'required'
        ]);
        $vat = Settings::where('slug', 'vat')->first();
        if(!empty($vat)) {
            $vat->amount = $request->amount;
            $vat->no_days = $request->no_days;
            $vat->type = 2;
            $vat->slug = 'vat';
            $vat->save();
        } else {
            $vat = new Settings();
            $vat->amount = $request->amount;
            $vat->no_days = $request->no_days;
            $vat->type = 2;
            $vat->slug = 'vat';
            $vat->save();
        }
        return redirect('/admin/vat/create')->with('success', 'Vat % Successfully Updated!');
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
