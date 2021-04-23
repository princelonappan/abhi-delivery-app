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
        $authService = app('App\Services\AuthProxy');
        $user = $authService->identityUser();
        $customer = $user->load('userable');
        if(request('type') == 'phone'){
            $creds = [
                'email' => $user->email,
                'password' => !empty(request('password'))?request('password'):$user->password
            ];
            if(!Auth::attempt($creds)) {
                 abort(401, 'The user is not authorized');
            }
            if($customer->otp) {
                abort(401);
            } 
            $response = $authService->getAccessToken($creds);    
        }
        $response['customer'] = $customer;
        
        return $response;
    }

    public function index()
    {
        return Customer::all();
    }
}