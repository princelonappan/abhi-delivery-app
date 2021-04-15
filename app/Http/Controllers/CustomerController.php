<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    

    public function register(CustomerRequest $request)
    {
        return Customer::create($request->all());
    }

    public function login(CustomerRequest $request)
    {
        $customer = Customer::where('phone_number',$request->phone_number)->first();
        $email = !empty($customer->user)?$customer->user->email:NULL;
        $creds = ['email' => $email, 'password' => $request->password];
        if(!Auth::attempt($creds)) {
             abort(401, 'The user is not authorized');
        }
        if($customer->otp) {
            abort(401);
        } 
        $authService = app('App\Services\AuthProxy');
        $tokenDetails = $authService->getAccessToken($creds);
        $tokenDetails['customer'] = $customer->load('user');
        return $tokenDetails;
    }
}