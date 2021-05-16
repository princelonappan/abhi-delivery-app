<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
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
        Customer::create($request->all());

        $authService = app('App\Services\AuthProxy');
        $user = $authService->identityUser();
        $customer = $user->load('userable');
        // $response = $authService->getAccessToken($creds);
        $response['customer'] = $customer;
        return $response;
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
        $customer->save();

        $user = User::where('userable_id', $id)->where('userable_type', 'customer')->first();
        if(!empty($user)) {
            $user->name = $request->name;
            $user->save();
        }

        $customer = Customer::with(['user'])->where('id', $id)->first();
        $data = [];
        $data['id'] = $customer->id;
        $data['name'] = $customer->name;
        $data['email'] = !empty($customer->user) ? $customer->user->email : "";
        $data['phone_number'] = $customer->phone_number;
        $data['status'] = $customer->status;
        // $data['otp'] = $customer->otp;
        $data['date_of_birth'] = $customer->date_of_birth;
        $data['created_at'] = $customer->created_at;
        $data['updated_at'] = $customer->updated_at;
        return $data;
    }

    // Generate OTP
    public function generateOtp(CustomerRequest $request) {
        $otp_value = rand(1000,9999);

        if(empty($request->customer_id)) {
            $exist = Customer::where('phone_number', $request->phone_number)->where('status', 'Active')->first();
            $sms = $this->sms($request->phone_number, $otp_value);
            if(!empty($exist)) {
                $responseArray['message'] = 'Mobile Already exists';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
            $data['otp'] = $otp_value;

            Otp::where('mobile', $request->phone_number)->delete();
            $otp = new Otp();
            $otp->mobile = $request->phone_number;
            $otp->otp = $otp_value;
            $otp->save();
            return $data;
        } else {
            if(empty($request->customer_id)) {
                $responseArray['message'] = 'Customer Id required';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
            $exist = Customer::where('phone_number', $request->phone_number)->where('id', '!=', $request->customer_id)->where('status', 'Active')->first();
            if(!empty($exist)) {
                $responseArray['message'] = 'Mobile Already exists';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
            $data['otp'] = $otp_value;
            Otp::where('mobile', $request->phone_number)->delete();
            $otp = new Otp();
            $otp->mobile = $request->phone_number;
            $otp->otp = $otp_value;
            $otp->save();
            $customer = Customer::with(['user'])->where('id', '!=', $request->customer_id)->first();
            $data = [];
            $data['id'] = $customer->id;
            $data['name'] = $customer->name;
            $data['email'] = !empty($customer->user) ? $customer->user->email : "";
            $data['phone_number'] = $customer->phone_number;
            $data['status'] = $customer->status;
            // $data['otp'] = $otp_value;
            $data['date_of_birth'] = $customer->date_of_birth;
            $data['created_at'] = $customer->created_at;
            $data['updated_at'] = $customer->updated_at;
            return $data;
        }

        $responseArray['message'] = 'Something went wrong';
        $responseArray['success'] = false;
        return response()->json($responseArray, 500);

    }

    // Update Email
    public function updateEmail(CustomerRequest $request) {
        $exist = User::where('email', $request->email)->where('userable_id', '!=', $request->customer_id)->first();
        if(empty($exist)) {
            $user = User::where('userable_id', $request->customer_id)->where('userable_type', 'customer')->first();
            if(!empty($user)) {
                $user->email = $request->email;
                $user->save();
            }


            $customer = Customer::with(['user'])->where('id', $request->customer_id)->first();
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

        $responseArray['message'] = 'Email already exists';
        $responseArray['success'] = false;
        return response()->json($responseArray, 500);
    }

    // Update Phone
    public function updatePhone(CustomerRequest $request) {
        $otp = Otp::where('mobile', $request->phone_number)->where('otp', $request->otp)->first();
        if(!empty($otp)) {
            $exist = Customer::where('phone_number', $request->phone_number)->where('id', '!=', $request->customer_id)->first();
            if(empty($exist)) {
                $user = Customer::where('id', $request->customer_id)->first();
                $user->name = $user->name;
                $user->phone_number = $request->phone_number;
                $user->status = $user->status;
                $user->date_of_birth = $user->date_of_birth;
                $user->save();

                $otp = Otp::where('mobile', $request->phone_number)->delete();

                $customer = Customer::with(['user'])->where('id', $request->customer_id)->first();
                $data = [];
                $data['id'] = $customer->id;
                $data['name'] = $customer->name;
                $data['email'] = !empty($customer->user) ? $customer->user->email : "";
                $data['phone_number'] = $customer->phone_number;
                $data['status'] = $customer->status;
                $data['date_of_birth'] = $customer->date_of_birth;
                $data['created_at'] = $customer->created_at;
                $data['updated_at'] = $customer->updated_at;
                return $data;
            }

            $responseArray['message'] = 'Phone already exists';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }
        $responseArray['message'] = 'Invalid OTP';
        $responseArray['success'] = false;
        return response()->json($responseArray, 500);

    }

    // SMS gateway
    public function sms($mobile, $otp) {
        $mobile = $mobile;
        $api_key = env('SMS_API');
        $api_url = env('SMS_URL');
        $message = 'Your OTP is '.$otp;

        // Build the URL to send the message to. Make sure the
        // message text and Sender ID are URL encoded. You can
        // use HTTP or HTTPS
        $url =  ($api_url .'?apiKey=' . $api_key . '&to=' . $mobile . '&content=' . urlencode($message));
        // Send the request
        // create a new cURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // grab URL and pass it to the browser
        curl_exec($ch);

        // close cURL resource, and free up system resources
        curl_close($ch);
    }
}
