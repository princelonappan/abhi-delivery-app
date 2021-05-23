<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;

use App\DistributorOrder;
use Mail;
use App\DistributorCart;
use App\Address;
use App\Customer;
use App\Settings;
use App\User;
use App\PaymentTransaction;
use App\Http\Requests\DistributorOrderRequest;
use App\Notifications\OrderNotification;
use App\PaletInventory;
use Illuminate\Notifications\Notification;

class DistributorOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_type = config('genaral.delivery_type');
        $orders = DistributorOrder::where('distributor_id', request('distributor_id'))->orderBy('created_at', 'desc')->get();
        $data = [];
        foreach($orders as $key => $order) {

            $data[$key]["id"] = $order->id;
            $data[$key]["order_no"] = $order->order_no;
            $data[$key]["distributor_id"] = $order->distributor_id;
            $data[$key]["status"] = $order->status;
            $data[$key]["palet_order_total"] = $order->palet_order_total;
            $data[$key]["product_total"] =  $order->product_total;
            $data[$key]["vat"] =  $order->vat;
            $data[$key]["vat_percentage"] =  $order->vat_percentage;
            $data[$key]["delivery_charge"] =  $order->delivery_charge;
            $data[$key]["delivery_charge_percentage"] =  $order->delivery_charge_percentage;
            $data[$key]["delivery_charge_min_amount"] =  $order->delivery_charge_min_amount;
            $data[$key]["payment_type"] =  $order->payment_type;
            $data[$key]["delivery_type"] = $order->delivery_type;
            $data[$key]["created_at"] =  $order->created_at;
            $data[$key]["updated_at"] =  $order->updated_at;
            $data[$key]["items"] = $order->items;

        }
        // return $orders->load('items');
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistributorOrderRequest $request)
    {

        $latestOrder = !empty(DistributorOrder::orderBy('created_at','DESC')->first()) ? DistributorOrder::orderBy('created_at','DESC')->first()->id : 0;
        $order_nr = 'ORD'.str_pad($latestOrder + 1, 8, "0", STR_PAD_LEFT);
        if(empty(request('payment_type')) && request('payment_type') == 2) {
            if(!empty(request('transaction_id'))) {
                $responseArray['message'] = 'Invalid Transactions';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
        }

        if(empty(request('delivery_type')) && request('delivery_type') == 1) {
            if(!empty(request('transaction_id'))) {
                $responseArray['message'] = 'Invalid Transactions';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
        }

        $cart = DistributorCart::find(request('cart_id'))->load('items');
        $val = Settings::where('slug', 'vat')->first();
        $delivery_charge = Settings::where('slug', 'delivery_charge')->first();
        $order = DistributorOrder::create([
            'distributor_id' => $cart->distributor_id,
            'palet_order_total' => request('order_total'),
            'product_total' => request('product_total'),
            'delivery_charge' => request('delivery_charge'),
            'delivery_charge_percentage' => $delivery_charge->amount,
            'delivery_charge_min_amount' => $delivery_charge->min_amount,
            'vat' => request('vat'),
            'vat_percentage' => !empty($val) ? $val->amount : 0,
            'payment_type' => request('payment_type'),
            'delivery_type' => request('delivery_type'),
            'order_no' => $order_nr
        ]);

        $order->createOrderItems($cart);
        if(!empty(request('delivery_type')) && request('delivery_type') == 1) {

            $responseArray = [];

            $responseArray['success'] = false;
            if(empty(request('address'))) {
                $responseArray['message'] = 'The address field is required.';
                return response()->json($responseArray, 400);
            }

            if(empty(request('address_type'))) {
                $responseArray['message'] = 'The address type field is required.';
                return response()->json($responseArray, 400);
            }
            if(empty(request('city'))) {
                $responseArray['message'] = 'The city field is required.';
                return response()->json($responseArray, 400);
            }
            if(empty(request('state'))) {
                $responseArray['message'] = 'The state field is required.';
                return response()->json($responseArray, 400);
            }
            if(empty(request('zip'))) {
                $responseArray['message'] = 'The zip field is required.';
                return response()->json($responseArray, 400);
            }
            if(empty(request('country'))) {
                $responseArray['message'] = 'The country field is required.';
                return response()->json($responseArray, 400);
            }

            $order->address()->create($request->except(['cart_id', 'palet_order_total']));
        }
        $cart->update(['status' => 'Checked Out']);

        if(request('payment_type') == 2 && !empty(request('transaction_id'))) {
            $transcation = PaymentTransaction::where('payment_transaction_id', request('transaction_id'))->first();
            $transcation->order_id = $order->id;
            $transcation->save();
        } else {
            if(request('payment_type') != 1) {
                $responseArray['message'] = 'Invalid Transactions';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }

        }

        $user = User::where('userable_id', $cart->distributor_id)->where('userable_type', 'distributor')->first();
        $order = DistributorOrder::find($order->id);
        $mail = $this->sendNotification($order,$user);
        $delivery_type = config('genaral.delivery_type');
        // $order->delivery_type = $delivery_type[$order->delivery_type];
        return $order->load('items');
    }

    public function sendNotification($order,$user) {

        try {

            $customer = Customer::where('id', $user->userable_id)->first();
            // $details = [
            //     'greeting' => 'Hi '.$customer->name,
            //     'body' => 'Your order hasbeen completed',
            //     'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            //     'actionText' => 'View My Site',
            //     'actionURL' => url('/'),
            //     'order_id' => $order->id
            // ];
            // Notification::send($user, new OrderNotification($details));

            $data = [
                'order_no' => $order->order_id,
                'product_price' => $order->product_total,
                'palet_order_total' => $order->palet_order_total,
                'vat' => $order->vat,
                'delivery_charge' => $order->delivery_charge,
                'name' => $customer->name,
            ];

            $toeMail = 'niyaspulath@gmail.com';
            $mail = Mail::send('email.order', $data, function($message) use ($user,$toeMail) {
                        $message->from('niyaspulath@gmail.com');
                        $message->to($toeMail);
                        $message->subject('Order Details');
                    });

          } catch (\Exception $e) {

              return $e->getMessage();
          }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DistributorOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DistributorOrder::findOrFail($id)->load('items', 'items.product', 'items.product.images');
        $count_order_products = $data->items->count();
        // $palet_order = PaletInventory::where('distributor_order_id', $id)->where('')
        // $delivery_type = config('genaral.delivery_type');
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(DistributorOrderRequest $request) {
        $order = DistributorOrder::where('id', $request->id)->where('distributor_id', $request->distributor_id)->first();
        if(!empty($order)) {
            $order->status = "Canceled";
            $order->save();
            $order = DistributorOrder::findOrFail($request->id)->load('items', 'items.product', 'items.product.images');
            $delivery_type = config('genaral.delivery_type');
            // $order->delivery_type = $delivery_type[$order->delivery_type];
            return $order;
        }
        $responseArray['message'] = 'Something went wrong';
        $responseArray['success'] = false;
        return response()->json($responseArray, 500);
    }
}
