<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\Address;
use App\Customer;
use App\Settings;
use App\User;
use App\PaymentTransaction;
use App\Http\Requests\OrderRequest;
use App\Notifications\OrderNotification;
use Illuminate\Notifications\Notification;
use Mail;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('customer_id', request('customer_id'))->orderBy('created_at', 'desc')->get();
        return $orders->load('items');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $latestOrder = !empty(Order::orderBy('created_at','DESC')->first()) ? Order::orderBy('created_at','DESC')->first()->id : 0;
        $order_nr = 'ORD'.str_pad($latestOrder + 1, 8, "0", STR_PAD_LEFT);
        if(empty(request('payment_type')) && request('payment_type') == 2) {
            if(!empty(request('transaction_id'))) {
                $responseArray['message'] = 'Invalid Transactions';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
        }
        $cart = Cart::find(request('cart_id'))->load('items');
        $val = Settings::where('slug', 'vat')->first();
        $delivery_charge = Settings::where('slug', 'delivery_charge')->first();
        $order = Order::create([
            'customer_id' => $cart->customer_id,
            'order_total' => request('order_total'),
            'product_total' => request('product_total'),
            'delivery_charge' => request('delivery_charge'),
            'delivery_charge_percentage' => $delivery_charge->amount,
            'delivery_charge_min_amount' => $delivery_charge->min_amount,
            'vat' => request('vat'),
            'vat_percentage' => !empty($val) ? $val->amount : 0,
            'payment_type' => request('payment_type'),
            'order_id' => $order_nr
        ]);
        $order->createOrderItems($cart);
        $order->address()->create($request->except(['cart_id', 'order_total']));
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
        $user = User::where('userable_id', $cart->customer_id)->where('userable_type', 'customer')->first();
        $order = Order::find($order->id);
        $mail = $this->sendNotification($order,$user);

        return $order->load('items');
    }

    public function sendNotification($order,$user) {
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
            'order_id' => $order->order_id,
            'product_price' => $order->product_total,
            'order_total' => $order->order_total,
            'vat' => $order->vat,
            'delivery_charge' => $order->delivery_charge,
            'name' => $customer->name,
        ];

        $toeMail = $user->email;
        $mail = Mail::send('emails.order', $data, function($message) use ($user,$toeMail) {
                    $message->from('niyaspulath@gmail.com');
                    $message->to($toeMail);
                    $message->subject('Order Details');
                });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::findOrFail($id)->load('items', 'items.product', 'items.product.images');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(OrderRequest $request) {
        $order = Order::where('id', $request->id)->where('customer_id', $request->customer_id)->first();
        if(!empty($order)) {
            $order->status = "Canceled";
            $order->save();
            return Order::findOrFail($request->id)->load('items', 'items.product', 'items.product.images');
        }
        $responseArray['message'] = 'Something went wrong';
        $responseArray['success'] = false;
        return response()->json($responseArray, 500);
    }
}
