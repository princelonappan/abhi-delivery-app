<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Distributor;

class DistributorController extends Controller
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
        if ($request->wantsJson) {
            $distributor = Distributor::all();
            return $distributor;
        } else {
            $distributor = Distributor::paginate(10);
            return view('admin.distributor.list-distributor')->with('distributor', $distributor);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.distributor.add-distributor');
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
            'distributor_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required|unique:distributor'
        ]);

        $distributor = new Distributor([
            'name' => $request->get('distributor_name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'phone_number' => $request->get('phone_number'),
            'status' => 1
        ]);
        $distributor->save();
        return redirect('/admin/distributor')->with('success', 'Distributor saved!');
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
        $distributor = Distributor::find($id);
        return view('admin.distributor.edit-distributor', compact('distributor'));   
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
            'distributor_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => "required|unique:distributor,phone_number,$id,id",
        ]);

        $distributor = Distributor::find($id);
        $distributor->name =  $request->get('distributor_name');
        $distributor->email =  $request->get('email');
        $distributor->password =  $request->get('password');
        $distributor->phone_number =  $request->get('phone_number');
        $distributor->save();
        return redirect('/admin/distributor')->with('success', 'Category Updated!');
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
        $distributor = Distributor::find($id);
        $distributor->delete();

        return redirect('/admin/distributor')->with('success', 'Category deleted!');
    }
}
