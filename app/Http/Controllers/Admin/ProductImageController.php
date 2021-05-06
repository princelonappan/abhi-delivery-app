<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\ProductImage;
use Illuminate\Support\Facades\File;

// use App\File;


class ProductImageController extends Controller
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
    public function index($product_id, Request $request)
    {
        if ($request->wantsJson) {
            $images = ProductImage::all();
            return $images;
        } else {
            $images = ProductImage::paginate(10);

            return view('admin.image.list-image', compact('images', 'product_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        $product = Product::find($product_id);
        $categories = Category::where('status', 1)->get();
        return view('admin.image.add-image', compact('categories', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($product_id, Request $request)
    {
        $this->validate($request, [
            'files' => 'required'
        ]);
        $path = public_path() . '/images/';
        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                $name = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('images'), $name);
                $product = new ProductImage([
                    'product_id' => $product_id,
                    'image_name' => $name,
                    'image_url' => url('images/'.$name)
                ]);
                $product->save();
            }
        }
        return back()->with('success', 'Files uploaded successfully');
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $image_id)
    {
        $image = ProductImage::find($image_id);
        $image_name = $image->image_name;
        $image_path = public_path() . '/images/'.$image_name;
        File::delete($image_path);
        $image->delete();
        return redirect('/admin/products/'.$product_id.'/image')->with('success', 'Product Image deleted!');
    }
}
