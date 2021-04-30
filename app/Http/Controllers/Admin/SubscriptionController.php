<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subscription;

class SubscriptionController extends Controller
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
        $subscription = Subscription::where('slug', 'subscription')->first();
        return view('admin.subscription.subscription', compact('subscription'));
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
            'subscription_amount' => 'required',
            'no_days' => 'required|integer'
        ]);
        $subscription = Subscription::where('slug', 'subscription')->first();
        if(!empty($subscription)) {
            $subscription->subscription_amount = $request->subscription_amount;
            $subscription->no_days = $request->no_days;
            $subscription->save();
        } else {
            $subscription = new Subscription();
            $subscription->subscription_amount = $request->subscription_amount;
            $subscription->no_days = $request->no_days;
            $subscription->slug = 'subscription';
            $subscription->save();
        }
        return redirect('/admin/subscription/create')->with('success', 'Subscription Updated!');

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
