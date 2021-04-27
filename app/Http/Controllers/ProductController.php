<?php

namespace App\Http\Controllers;

use App\Product;
use App\Favourite;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!empty(request('category_id'))) {
            $products =  Product::where('category_id', request('category_id'))->get();
            return $products->load('category', 'items', 'images');
        }
        if(!empty(request('customer_id'))) {
            $products = Product::all()->load('category', 'items', 'images');
            $data = [];
            foreach($products as $key => $product) {
                $fav_product = Favourite::where('customer_id', request('customer_id'))->where('product_id', $product->id)->first();
                if(!empty($fav_product)) {
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

                } else {
                    $data[$key]['id'] = $product->id;
                    $data[$key]['title'] = $product->title;
                    $data[$key]['description'] = $product->description;
                    $data[$key]['price_per_unit'] = $product->price_per_unit;
                    $data[$key]['price_per_palet'] = $product->price_per_palet;
                    $data[$key]['unit'] = $product->unit;
                    $data[$key]['qty'] = $product->qty;
                    $data[$key]['category_id'] = $product->category_id;
                    $data[$key]['is_favourite'] = false;
                    $data[$key]['created_at'] = $product->created_at;
                    $data[$key]['updated_at'] = $product->updated_at;
                    $data[$key]['category'] = $product->category;
                    $data[$key]['items'] = $product->items;
                    $data[$key]['images'] = $product->images;
                }


            }
            return $data;
            if(!empty($fav_products)) {
                $products =  Product::whereIn('id', $fav_products)->get();
                return $products->load('category', 'items', 'images', 'favourite');

            }
        }

        return Product::all()->load('category', 'items', 'images');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
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
