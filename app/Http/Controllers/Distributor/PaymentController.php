<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;

use App\Product;
use App\DistributorCart;
use App\DistributorCartItem;
use App\Settings;
use App\DistributorPaymentTransaction;
use App\Address;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cart = DistributorCart::where('id', $request->cart_id)->with(['customer.user', 'items', 'items.product',  'items.product.category', 'items.product.images'])->where('status', 'Active')->first();
        $address = Address::where('id', $request->address_id)->where('id', $request->address_id)->first();
        if(empty($address)) {
            return 'Invalid Address';
        }
        if(!empty($cart)) {

            $vat = Settings::where('slug', 'vat')->first();
            $vat_persantage = !empty($vat->amount) ? $vat->amount : 0;
            $product_total = 0;
            foreach($cart->items as $item) {
                $product_total+=$item->price;
            }
            $vat_amount = (!empty($vat_persantage) && !empty($product_total)) ? ($vat_persantage/100)*$product_total : 0;
            $delivery = $vat = Settings::where('slug', 'delivery_charge')->first();
            $delivery_charge = 0;

            $delivery_charge = !empty($delivery) ? (($delivery->min_amount > $product_total) ? $delivery->amount : 0)  : 0;

            $total_amount = $delivery_charge+$vat_amount+$product_total;

            $total_amount = $total_amount*100;

            // dd($total_amount);

            // eWAY Credentials
            $apiKey = env('API_KEY');
            $apiPassword = env('API_PASSWORD');
            $apiEndpoint = env('END_POINT');

            // Create the eWAY Client
            $client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

            // Transaction details - these would usually come from the application
            $transaction = [
                'Customer' => [
                    'FirstName' => !empty($cart->customer) ? $cart->customer->name : '',
                    'LastName' => '',
                    'Street1' => $address->address,
                    'Street2' => $address->address2,
                    'City' => $address->city,
                    'State' => $address->state,
                    'PostalCode' => $address->zip,
                    'Country' => 'au',
                    'Email' => !empty($cart->customer) && !empty($cart->customer->user) ? $cart->customer->user->email : '',
                ],
                // These should be set to your actual website (on HTTPS of course)
                'RedirectUrl' => url('payments-response'),
                'CancelUrl' => url('payments-cancel'),
                'TransactionType' => \Eway\Rapid\Enum\TransactionType::PURCHASE,
                'Payment' => [
                    'TotalAmount' => $total_amount,
                ]
            ];

            // Submit data to eWAY to get a Shared Page URL
            $response = $client->createTransaction(\Eway\Rapid\Enum\ApiMethod::RESPONSIVE_SHARED, $transaction);

            // Check for any errors
            if (!$response->getErrors()) {
                $sharedURL = $response->SharedPaymentUrl;
            } else {
                foreach ($response->getErrors() as $error) {
                    echo "Error: ".\Eway\Rapid::getMessage($error)."";
                }
                die();
            }

            return redirect($sharedURL);
        } else {
            die('Invalid Cart');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // eWAY Credentials
        $apiKey = env('API_KEY');
        $apiPassword = env('API_PASSWORD');
        $apiEndpoint = \Eway\Rapid\Client::MODE_SANDBOX;

        // Create the eWAY Client
        $client = \Eway\Rapid::createClient($apiKey, $apiPassword, $apiEndpoint);

        // Query the transaction result.


        // $transaction = rand();

        // $payment_transaction = new DistributorPaymentTransaction();
        // $payment_transaction->payment_transaction_id = $transaction;
        // $payment_transaction->save();

        // return redirect('/payments-status?success=true&transaction_id='.$transaction);


        $response = $client->queryTransaction($_GET['AccessCode']);
        $transactionResponse = $response->Transactions[0];
        // Display the transaction result
        if ($transactionResponse->TransactionStatus) {
            $payment_transaction = new DistributorPaymentTransaction();
            $payment_transaction->payment_transaction_id = $transactionResponse->TransactionID;
            $payment_transaction->save();

            return redirect('/payments-status?success=true&transaction_id='.$transactionResponse->TransactionID);
            // return 'Payment successful! ID: ' .$transactionResponse->TransactionID;
        } else {
            $errors = split(', ', $transactionResponse->ResponseMessage);
            foreach ($errors as $error) {
                echo "Payment failed: " .\Eway\Rapid::getMessage($error)."";
            }
            return redirect('/payments-status?success=false');
        }

    }

    public function status(Request $request) {
        return 'Payment successful! ID: ' .$request->transaction_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
