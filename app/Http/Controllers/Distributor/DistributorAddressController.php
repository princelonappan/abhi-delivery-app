<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;

use App\Http\Requests\AddressRequest;
use App\Branch;
use App\Address;

class DistributorAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

            // 'addressable_type' => request('addressable_type')
        $branches = Branch::where('distributor_id', request('distributor_id'))->get();
        $data = [];
        foreach($branches as $key => $branch) {
            $branch_address = Address::where('addressable_type', 'branch')->where('addressable_id', $branch->id)->first();
            $data[$key]['id'] = $branch->id;
            $data[$key]['branch_name'] = $branch->branch_name;
            $data[$key]['distributor_id'] = $branch->distributor_id;
            $data[$key]['phone_number'] = $branch->phone_number;
            $data[$key]['addressable_type'] = $branch_address->addressable_type;
            $data[$key]['address_type'] = $branch_address->address_type;
            $data[$key]['address'] = $branch_address->address;
            $data[$key]['address2'] = $branch_address->address2;
            $data[$key]['city'] = $branch_address->city;
            $data[$key]['state'] = $branch_address->state;
            $data[$key]['zip'] = $branch_address->zip;
            $data[$key]['country'] = $branch_address->country;
            $data[$key]['status'] = $branch->status;
            $data[$key]['created_at'] = $branch->created_at;
            $data[$key]['updated_at'] = $branch->updated_at;

        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        // return Address::create($request->all())->load('addressable');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Address::findOrFail($id)->load('addressable');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        // $address = Address::findOrFail($id);
        // $address->update($request->except('addressable_type', 'addressable_id'));
        // return $address->load('addressable');
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
    }
}
