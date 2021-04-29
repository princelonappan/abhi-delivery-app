<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use App\Product;
use App\Http\Requests\FavouriteRequest;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(empty($request->customer_id)) {
            $responseArray['message'] = 'Customer ID required';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }
        $favourites = Favourite::with(['products'])->where('customer_id', $request->customer_id)->get();
        $data = [];
        if(!$favourites->isEmpty()) {
            foreach($favourites as $key => $favourite) {
                $product = Product::where('id', $favourite->product_id)->first();
                if(!empty($product)) {
                    $data[$key]['favourite_id'] = $favourite->id;
                    $data[$key]['id'] = $product->id;
                    $data[$key]['title'] = $product->title;
                    $data[$key]['description'] = $product->description;
                    $data[$key]['price_per_unit'] = $product->price_per_unit;
                    $data[$key]['price_per_palet'] = $product->price_per_palet;
                    $data[$key]['unit'] = $product->unit;
                    $data[$key]['qty'] = $product->qty;
                    $data[$key]['category_id'] = $product->category_id;
                    $data[$key]['is_favourite'] = true;
                    $data[$key]['created_at'] = $product->created_at;
                    $data[$key]['updated_at'] = $product->updated_at;
                    $data[$key]['category'] = $product->category;
                    $data[$key]['items'] = $product->items;
                    $data[$key]['images'] = $product->images;
                }

            }
        }
        return $data;
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
    public function store(FavouriteRequest $request)
    {
        $exists = Favourite::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->first();
        if(!empty($exists)) {
            $responseArray['message'] = 'Favourite alredy added';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }
        $favourite = new Favourite();
        $favourite->customer_id = $request->customer_id;
        $favourite->product_id  = $request->product_id;
        $favourite->save();
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
        $exists = Favourite::where('id', $id)->first();
        if(empty($exists)) {
            $responseArray['message'] = 'Favourite not found';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }
        $favourite = Favourite::find($id);
        $favourite->delete();

    }
}
