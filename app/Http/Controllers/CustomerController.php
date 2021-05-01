<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Auth;
use App\Otp;

class CustomerController extends Controller
{


    public function register(CustomerRequest $request)
    {
        $otp = Otp::where('mobile', $request->phone_number)->where('otp', $request->otp)->first();
        if(empty($otp)) {
            $responseArray['message'] = 'Invalid OTP';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }
        Otp::where('mobile', $request->phone_number)->delete();
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

    public function show($id)
    {
        $customer = Customer::with(['user'])->where('id', $id)->first();
        $data = [];
        $data['id'] = $customer->id;
        $data['name'] = $customer->name;
        $data['email'] = !empty($customer->user) ? $customer->user->email : "";
        $data['phone_number'] = $customer->phone_number;
        $data['status'] = $customer->status;
        $data['otp'] = $customer->otp;
        $data['date_of_birth'] = $customer->date_of_birth;
        $data['created_at'] = $customer->created_at;
        $data['updated_at'] = $customer->updated_at;
        return $data;

    }

    public function update(CustomerRequest $request, $id)
    {

        $customer =  Customer::find($id);
        $customer->name = $request->name;
        $customer->phone_number = !empty($request->phone_number) ? $request->phone_number : $customer->phone_number;
        $customer->date_of_birth = !empty($request->date_of_birth) ? $request->date_of_birth : $customer->date_of_birth;


        $user = User::where('email', '=', $request->email)->where('userable_id', '!=', $id)->first();
        if(!empty($user)) {
            $responseArray['message'] = 'Email Already exists';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);

        } else {
            $user = User::where('userable_type', 'customer')->where('userable_id', $id)->first();
            $user->email = $request->email;
            $user->save();
        }

        $customer->save();

        $customer = Customer::with(['user'])->where('id', $id)->first();
        $data = [];
        $data['id'] = $customer->id;
        $data['name'] = $customer->name;
        $data['email'] = !empty($customer->user) ? $customer->user->email : "";
        $data['phone_number'] = $customer->phone_number;
        $data['status'] = $customer->status;
        $data['otp'] = $customer->otp;
        $data['date_of_birth'] = $customer->date_of_birth;
        $data['created_at'] = $customer->created_at;
        $data['updated_at'] = $customer->updated_at;
        return $data;
    }

    // Generate OTP
    public function generateOtp(CustomerRequest $request) {
        $exist = Customer::where('phone_number', $request->phone_number)->where('status', 'Active')->first();
        if(!empty($exist)) {
            $responseArray['message'] = 'Mobile Already exists';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }

        $otp_value = rand(1000,9999);
        // $otp_value = 1234;

        $data['otp'] = $otp_value;

        Otp::where('mobile', $request->phone_number)->delete();
        $otp = new Otp();
        $otp->mobile = $request->phone_number;
        $otp->otp = $otp_value;
        $otp->save();
        return $data;
    }
}
