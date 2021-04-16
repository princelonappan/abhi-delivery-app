<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Distributor;
use App\User;
use App\Branch;
use App\Address;
use Illuminate\Support\Facades\Hash;


class BranchController extends Controller
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
    public function index($distributor_id, Request $request)
    {
        if ($request->wantsJson) {
            $branch = Distributor::all();
            return $branch;
        } else {
            $branch = Branch::paginate(10);
            return view('admin.branch.list-branch', compact('branch', 'distributor_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($distributor_id)
    {
        return view('admin.branch.add-branch', compact('distributor_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($distributor_id, Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'phone_number' => 'required|unique:branches'
        ]);

        $branch = new Branch([
            'branch_name' => $request->get('branch_name'),
            'phone_number' => $request->get('phone_number'),
            'status' => 1,
            'distributor_id' => $distributor_id
        ]);

        $branch->save();
        $branch_id = $branch->id;
        $hashed_password = Hash::make($request->get('password'));

        $user = new User([
            'userable_type' => 'branch',
            'userable_id' => $branch_id,
            'name' => $request->get('branch_name'),
            'email' => $request->get('email'),
            'password' => $hashed_password
        ]);
        $user->save();

        $address = new Address([
            'addressable_type' => 'branch',
            'addressable_id' => $branch_id,
            'address_type' => 'default',
            'address' => $request->get('address1'),
            'address2' => $request->get('address2'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'country' => $request->get('country'),
            'zip' => $request->get('zip'),
        ]);

        $address->save();

        return redirect('/admin/distributor/'.$distributor_id.'/branch')->with('success', 'Branch saved!');
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
            'phone_number' => "required|unique:distributors,phone_number,$id,id",
        ]);

        $distributor = Distributor::find($id);
        $distributor->name =  $request->get('distributor_name');
        $distributor->phone_number =  $request->get('phone_number');
        $distributor->save();

        $updateFields = array("name"=> $request->get('distributor_name'), "email" => $request->get('email'));
        $password = $request->get('password');
        if(isset($password) && !empty($password)) {
            $updateFields = array_merge($updateFields, array('password' => Hash::make($password)));
        }
        User::where(['userable_type'=> 'distributor','userable_id'=> $id])->update($updateFields);
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
        $distributor = Distributor::find($id);
        $distributor->delete();

        $whereArray = array('userable_type' => 'distributor','userable_id' => $id);
        User::where($whereArray)->delete();

        return redirect('/admin/distributor')->with('success', 'Distributor deleted!');
    }
}
