<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Favourite;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $data = [];
        $featured_products = Product::with(['category', 'items', 'images'])->where('is_featured', 1)->where('status', 1)->get();
        $special_products = Product::with(['category', 'items', 'images'])->where('is_special_product', 1)->where('status', 1)->get();
        $products = Product::with(['category', 'items', 'images'])->where('is_special_product', '!=', 1)
                                ->where('is_featured', '!=', 1)->where('status', 1)->take(5)->get();
        foreach($featured_products as $key => $featured_product) {
            if (!empty(request('customer_id'))) {
                $fav_product = Favourite::where('customer_id', request('customer_id'))->where('product_id', $featured_product->id)->first();
            }
            $data['featured_products'][$key]['favourite_id'] = !empty($fav_product) ? $fav_product->id : null;
            $data['featured_products'][$key]['id'] = $featured_product->id;
            $data['featured_products'][$key]['title'] = $featured_product->title;
            $data['featured_products'][$key]['description'] = $featured_product->description;
            $data['featured_products'][$key]['price_per_unit'] = $featured_product->price_per_unit;
            $data['featured_products'][$key]['price_per_palet'] = $featured_product->price_per_palet;
            $data['featured_products'][$key]['unit'] = $featured_product->unit;
            $data['featured_products'][$key]['qty'] = $featured_product->qty;
            $data['featured_products'][$key]['category_id'] = $featured_product->category_id;
            $data['featured_products'][$key]['is_favourite'] = !empty($fav_product) ? true : false;
            $data['featured_products'][$key]['is_featured'] = $featured_product->is_featured;
            $data['featured_products'][$key]['is_special_product'] = $featured_product->is_special_product;
            $data['featured_products'][$key]['created_at'] = $featured_product->created_at;
            $data['featured_products'][$key]['updated_at'] = $featured_product->updated_at;
            $data['featured_products'][$key]['category'] = $featured_product->category;
            $data['featured_products'][$key]['items'] = $featured_product->items;
            $data['featured_products'][$key]['images'] = $featured_product->images;
        }

        foreach($special_products as $key => $special_product) {
            if (!empty(request('customer_id'))) {
                $fav_product = Favourite::where('customer_id', request('customer_id'))->where('product_id', $special_product->id)->first();
            }
            $data['special_product'][$key]['favourite_id'] = !empty($fav_product) ? $fav_product->id : null;
            $data['special_product'][$key]['id'] = $special_product->id;
            $data['special_product'][$key]['title'] = $special_product->title;
            $data['special_product'][$key]['description'] = $special_product->description;
            $data['special_product'][$key]['price_per_unit'] = $special_product->price_per_unit;
            $data['special_product'][$key]['price_per_palet'] = $special_product->price_per_palet;
            $data['special_product'][$key]['unit'] = $special_product->unit;
            $data['special_product'][$key]['qty'] = $special_product->qty;
            $data['special_product'][$key]['category_id'] = $special_product->category_id;
            $data['special_product'][$key]['is_favourite'] = !empty($fav_product) ? true : false;
            $data['special_product'][$key]['is_featured'] = $special_product->is_featured;
            $data['special_product'][$key]['is_special_product'] = $special_product->is_special_product;
            $data['special_product'][$key]['created_at'] = $special_product->created_at;
            $data['special_product'][$key]['updated_at'] = $special_product->updated_at;
            $data['special_product'][$key]['category'] = $special_product->category;
            $data['special_product'][$key]['items'] = $special_product->items;
            $data['special_product'][$key]['images'] = $special_product->images;

        }

        foreach($products as $key => $product) {
            if (!empty(request('customer_id'))) {
                $fav_product = Favourite::where('customer_id', request('customer_id'))->where('product_id', $product->id)->first();
            }
            $data['products'][$key]['favourite_id'] = !empty($fav_product) ? $fav_product->id : null;
            $data['products'][$key]['id'] = $product->id;
            $data['products'][$key]['title'] = $product->title;
            $data['products'][$key]['description'] = $product->description;
            $data['products'][$key]['price_per_unit'] = $product->price_per_unit;
            $data['products'][$key]['price_per_palet'] = $product->price_per_palet;
            $data['products'][$key]['unit'] = $product->unit;
            $data['products'][$key]['qty'] = $product->qty;
            $data['products'][$key]['category_id'] = $product->category_id;
            $data['products'][$key]['is_favourite'] = !empty($fav_product) ? true : false;
            $data['products'][$key]['is_featured'] = $product->is_featured;
            $data['products'][$key]['is_special_product'] = $product->is_special_product;
            $data['products'][$key]['created_at'] = $product->created_at;
            $data['products'][$key]['updated_at'] = $product->updated_at;
            $data['products'][$key]['category'] = $product->category;
            $data['products'][$key]['items'] = $product->items;
            $data['products'][$key]['images'] = $product->images;
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
    public function store(Request $request)
    {

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

    }
}
