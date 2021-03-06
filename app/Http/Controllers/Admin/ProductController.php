<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_id  = $request->category_filter;
        $categories = Category::where('status', 1)->get();
        if ($request->wantsJson) {
            if(!empty($category_id)) {
                $products = Product::where('category_id', $category_id)->get();
            } else {
                $products = Product::all();
            }

            return $products;
        } else {
            if (!empty($category_id)) {
                $products = Product::where('category_id', $category_id)->paginate(10);
            } else {
                $products = Product::paginate(10);
            }
            return view('admin.product.list-product', compact('products', 'categories', 'category_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.product.add-product', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_title' => 'required',
            'description' => 'required',
            'price_per_unit' => 'required',
            'price_per_palet' => 'required',
            'unit' => 'required',
            'quantity' => 'required',
            'category' => 'required',
        ]);

        $product = new Product([
            'title' => $request->get('product_title'),
            'description' => $request->get('description'),
            'price_per_unit' => $request->get('price_per_unit'),
            'price_per_palet' => $request->get('price_per_palet'),
            'unit' => $request->get('unit'),
            'qty' => $request->get('quantity'),
            'category_id' => $request->get('category'),
            'is_special_product' => $request->get('speical_product') == 1 ? 1 : 0,
            'is_featured' => $request->get('is_featured') == 1 ? 1 : 0,
            'status' => $request->get('status') == 1 ? 1 : 0,
        ]);
        $product->save();
        return redirect('/admin/products')->with('success', 'Product saved!');
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
        $product = Product::find($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.product.edit-product', compact('product', 'categories'));
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
        $request->validate([
            'product_title' => 'required',
            'description' => 'required',
            'price_per_unit' => 'required',
            'price_per_palet' => 'required',
            'unit' => 'required',
            'quantity' => 'required',
            'category' => 'required',
        ]);
        $product = Product::find($id);
        $product->title =  $request->get('product_title');
        $product->description =  $request->get('description');
        $product->price_per_unit =  $request->get('price_per_unit');
        $product->price_per_palet =  $request->get('price_per_palet');
        $product->unit =  $request->get('unit');
        $product->qty =  $request->get('quantity');
        $product->category_id =  $request->get('category');
        $product->is_special_product =  $request->get('speical_product') == 1 ? 1 : 0;
        $product->is_featured =  $request->get('is_featured') == 1 ? 1 : 0;
        $product->status =  $request->get('status') == 1 ? 1 : 0;

        $product->save();
        return redirect('/admin/products')->with('success', 'Product Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $distributor = Product::find($id);
        $distributor->delete();

        return redirect('/admin/products')->with('success', 'Product deleted!');
    }


    // Update Status
    public function updateStatus(Request $request) {
        $status = $request->status;
        $id = $request->dataId;
        $branch = Product::find($id);
        $branch->status = $status;
        $branch->save();
    }
}
