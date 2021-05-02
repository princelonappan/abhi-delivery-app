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
        $products =  Product::with(['category', 'items', 'images'])->where('status', 1);

        if(!empty(request('category_id'))) {
            $products = $products->where('category_id', request('category_id'));

        }

        if(!empty(request('is_special_product'))) {
            $products = $products->where('is_special_product', 1);
        } else {
            $products = $products->where('is_special_product', '!=', 1);
        }

        if(!empty(request('is_featured'))) {
            $products = $products->where('is_featured', 1);
        } else {
            $products = $products->where('is_featured', '!=', 1);
        }

        $products = $products->get();
        $data = [];
        foreach($products as $key => $product) {
            if (!empty(request('customer_id'))) {

                $fav_product = Favourite::where('customer_id', request('customer_id'))->where('product_id', $product->id)->first();

                if (!empty($fav_product)) {
                    $data[$key]['favourite_id'] = $fav_product->id;
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
                    $data[$key]['favourite_id'] = null;
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
            } else {
                $data[$key]['favourite_id'] = null;
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
    public function show($id)
    {
        $product =  Product::with(['category', 'items', 'images'])->where('status', 1)->where('id', $id)->first();

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
