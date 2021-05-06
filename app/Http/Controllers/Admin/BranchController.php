<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Distributor;
use App\User;
use App\Branch;
use App\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


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
        $distributor = Distributor::find($distributor_id);
        if ($request->wantsJson) {
            $branch = Distributor::where('status', 1)->get();
            return $branch;
        } else {
            $branch = Branch::where('distributor_id', $distributor_id)->paginate(10);
            return view('admin.branch.list-branch', compact('branch', 'distributor_id', 'distributor'));
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
            'email' => 'required|unique:users,email,NULL,id',
            'password' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => ['required', Rule::unique('addresses')->where(function ($query) {
                return $query->where('addressable_type', 'branch');
            }), ],
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
            'address2' => (!empty($request->get('address2')) ? $request->get('address2') : ''),
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
    public function edit($distributor_id, $id)
    {
        $branch = Branch::find($id);
        return view('admin.branch.edit-branch', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($distributor_id, $id, Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'email' => "required|unique:users,email,$id,userable_id",
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => ['required', Rule::unique('addresses')->ignore($id, 'addressable_id')->where(function ($query) {
                return $query->where('addressable_type', 'branch');
            }), ],
            'country' => 'required',
            'phone_number' => "required|unique:branches,phone_number,$id,id",
        ]);

        //Updating the Branch table
        $branch = Branch::find($id);
        $branch->branch_name = $request->get('branch_name');
        $branch->phone_number = $request->get('phone_number');
        $branch->status = 1;
        $branch->save();

        //Updating the User table
        $updateFields = array("name"=> $request->get('branch_name'), "email" => $request->get('email'));
        $password = $request->get('password');

        if(isset($password) && !empty($password)) {
            $updateFields = array_merge($updateFields, array('password' => Hash::make($password)));
        }
        User::where(['userable_type'=> 'branch','userable_id'=> $id])->update($updateFields);

        //Updating the Address table
        $addressUpdate = array(
            'address' => $request->get('address1'),
            'address2' => (!empty($request->get('address2')) ? $request->get('address2') : ''),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'country' => $request->get('country'),
            'zip' => $request->get('zip'),
        );
        Address::where(['addressable_type'=> 'branch','addressable_id'=> $id])->update($addressUpdate);

        return redirect('/admin/distributor/'.$distributor_id.'/branch')->with('success', 'Branch Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($distributor_id, $id)
    {
        $branch = Branch::find($id);
        $branch->delete();

        $whereArray = array('userable_type' => 'branch','userable_id' => $id);
        User::where($whereArray)->delete();


        $whereAddressArray = array('addressable_type' => 'branch','addressable_id' => $id);
        Address::where($whereAddressArray)->delete();

        return redirect('/admin/distributor/'.$distributor_id.'/branch')->with('success', 'Branch deleted!');
    }

    // Update Status
    public function updateStatus(Request $request) {
        $status = $request->status;
        $id = $request->dataId;
        $branch = Branch::find($id);
        $branch->status = $status;
        $branch->save();
    }
}
