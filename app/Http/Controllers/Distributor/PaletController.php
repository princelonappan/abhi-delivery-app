<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaletRequest;
use App\PaletInventory;
use App\DistributorOrder;
use App\DistributorOrderItem;
use App\Product;
use App\Favourite;
use GuzzleHttp\Psr7\Request;

class PaletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaletRequest $request)
    {
        $palet = PaletInventory::where('product_id', $request->product_id)->where('palet_id', $request->palet_id)->first();
        if(!empty($palet)) {
            $order = DistributorOrder::where('id', $request->order_id)->first();
            if(!empty($order)) {
                $palet->distributor_order_id = $request->order_id;
                $palet->save();


                $product =  Product::with(['category', 'items', 'images'])->where('status', 1)->where('id', $request->product_id)->first();

                if (!empty(request('customer_id'))) {

                    $fav_product = Favourite::where('customer_id', request('customer_id'))->where('product_id', $product->id)->first();

                    if (!empty($fav_product)) {
                        $data['favourite_id'] = $fav_product->id;
                        $data['id'] = $product->id;
                        $data['title'] = $product->title;
                        $data['description'] = $product->description;
                        $data['price_per_unit'] = $product->price_per_unit;
                        $data['price_per_palet'] = $product->price_per_palet;
                        $data['unit'] = $product->unit;
                        $data['qty'] = $product->qty;
                        $data['category_id'] = $product->category_id;
                        $data['is_favourite'] = true;
                        $data['created_at'] = $product->created_at;
                        $data['updated_at'] = $product->updated_at;
                        $data['category'] = $product->category;
                        $data['items'] = $product->items;
                        $data['images'] = $product->images;
                    } else {
                        $data['favourite_id'] = null;
                        $data['id'] = $product->id;
                        $data['title'] = $product->title;
                        $data['description'] = $product->description;
                        $data['price_per_unit'] = $product->price_per_unit;
                        $data['price_per_palet'] = $product->price_per_palet;
                        $data['unit'] = $product->unit;
                        $data['qty'] = $product->qty;
                        $data['category_id'] = $product->category_id;
                        $data['is_favourite'] = false;
                        $data['created_at'] = $product->created_at;
                        $data['updated_at'] = $product->updated_at;
                        $data['category'] = $product->category;
                        $data['items'] = $product->items;
                        $data['images'] = $product->images;
                    }
                } else {
                    $data['favourite_id'] = null;
                    $data['id'] = $product->id;
                    $data['title'] = $product->title;
                    $data['description'] = $product->description;
                    $data['price_per_unit'] = $product->price_per_unit;
                    $data['price_per_palet'] = $product->price_per_palet;
                    $data['unit'] = $product->unit;
                    $data['qty'] = $product->qty;
                    $data['category_id'] = $product->category_id;
                    $data['is_favourite'] = false;
                    $data['created_at'] = $product->created_at;
                    $data['updated_at'] = $product->updated_at;
                    $data['category'] = $product->category;
                    $data['items'] = $product->items;
                    $data['images'] = $product->images;
                }
                return $data;

            } else {
                $responseArray = [];
                $responseArray['success'] = false;
                $responseArray['message'] = 'Invalid Order ID.';
                return response()->json($responseArray, 400);

            }
        } else {
            $responseArray = [];
            $responseArray['success'] = false;
            $responseArray['message'] = 'Invalid Palet.';
            return response()->json($responseArray, 400);

        }
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
    public function update(PaletRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaletRequest $request)
    {
        $palet = PaletInventory::where('product_id', $request->product_id)->where('palet_id', $request->palet_id)->where('distributor_order_id', $request->order_id)->first();
        if(!empty($palet)) {
            $palet->distributor_order_id = null;
            $palet->save();
        } else {
            $responseArray = [];
            $responseArray['success'] = false;
            $responseArray['message'] = 'Invalid Palet.';
            return response()->json($responseArray, 400);

        }

    }

    public function completePalet(PaletRequest $request) {
        $item = DistributorOrderItem::where('distributor_order_id', $request->order_id)->where('product_id', $request->product_id)->first();
        if(!empty($item)) {
            $item->is_palet_full = true;
            $item->save();

            $order = DistributorOrder::findOrFail($item->distributor_order_id);
            $order->status = 'Collected';
            $order->save();
            return $order->load('items', 'items.product', 'items.product.images');
        } else {
            $responseArray = [];
            $responseArray['success'] = false;
            $responseArray['message'] = 'Invalid Palet.';
            return response()->json($responseArray, 400);

        }
    }


    public function paletLists(PaletRequest $request) {
        $palets = PaletInventory::where('product_id', $request->product_id)->where('distributor_order_id', $request->order_id)->get();
        $data = [];
        if(!$palets->isEmpty()) {
            foreach($palets as $key => $palet) {
                $product =  Product::with(['category', 'items', 'images'])->where('status', 1)->where('id', $palet->product_id)->first();
                $data[$key] = $product;
            }
        }
        return $data;
    }

}
