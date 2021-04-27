<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\Http\Requests\DistributorRequest;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistributorRequest $request)
    {
        $distributor = Distributor::where('phone_number',$request->phone_number)->first();
        $email = !empty($distributor->user)?$distributor->user->email:NULL;
        $creds = ['email' => $email, 'password' => $request->password];
        if(!Auth::attempt($creds)) {
             abort(401, 'The user is not authorized');
        }
        $authService = app('App\Services\AuthProxy');
        $tokenDetails = $authService->getAccessToken($creds);
        $tokenDetails['distributor'] = $distributor->load('user');
        return $tokenDetails;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distributor $distributor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Distributor  $distributor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distributor $distributor)
    {
        //
    }
}
