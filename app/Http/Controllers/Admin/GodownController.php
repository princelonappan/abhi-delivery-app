<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Godown;
use App\GodownZip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class GodownController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $error_zipcode;

    public function __construct()
    {
        
        $this->middleware('auth:admin');
        Validator::extend("godown_zipcode_validation", function ($attribute, $value, $parameters) {
            if($parameters && isset($parameters[1])) {
                $rules = [
                    'zip_code' => "required|unique:godown_zip_code,zip_code,$parameters[1],godown_id",
                ];
            } else {
                $rules = [
                    'zip_code' => 'required|unique:godown_zip_code'
                ];
            }
            $array_zip = explode(',', rtrim($value, ','));
            foreach ($array_zip as $zip) {

                $data = [
                    'zip_code' => trim($zip)    
                ];
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    $this->error_zipcode = $zip;
                    return false;
                }
            }
            return true;
        });

        Validator::replacer('godown_zipcode_validation', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':value', $this->error_zipcode, $message);
        });
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson) {
            $godown = Godown::all();
            return $godown;
        } else {
            $godown = Godown::paginate(10);
            return view('admin.godown.list-godown')->with('godown', $godown);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.godown.add-godown');
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
            'godown_name' => 'required',
            'godown_id' => 'required|unique:godown,godown_unique_id',
            'details' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'zip' => 'required|godown_zipcode_validation'
        ]);

        $godown = new Godown([
            'name' => $request->get('godown_name'),
            'godown_unique_id' => $request->get('godown_id'),
            'details' => $request->get('details'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
            'address' => $request->get('address'),
            'status' => 1
        ]);

        $godown->save();
        $godown_id = $godown->id;

        $array_zip = explode(',', rtrim($request->get('zip'), ','));
        foreach ($array_zip as $zip) {
            $godown_zip = new GodownZip([
                'godown_id' => $godown_id,
                'zip_code' => trim($zip)
            ]);
            $godown_zip->save();
        }

        return redirect('/admin/godown')->with('success', 'Godown saved!');
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
        $godown = Godown::find($id);
        if($godown) {
            $godown_zip = GodownZip::where('godown_id', $id)->get();
            $commazip = [];
            foreach($godown_zip as $zip) {
                $commazip[] = $zip->zip_code;
            }
            $godown_zip = join(', ', $commazip);
        }
        
        return view('admin.godown.edit-godown', compact('godown', 'godown_zip'));
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
            'godown_name' => 'required',
            'godown_id' => "required|unique:godown,godown_unique_id,$id,id",
            'details' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'zip' => "required|godown_zipcode_validation:,$id"
        ]);

        $godown = Godown::find($id);
        $godown->name =  $request->get('godown_name');
        $godown->godown_unique_id =  $request->get('godown_id');
        $godown->details =  $request->get('details');
        $godown->latitude =  $request->get('latitude');
        $godown->longitude =  $request->get('longitude');
        $godown->address =  $request->get('address');
        $godown->save();

        //Deleting the all the zipcodes and inserting it as new.
        $whereArray = array('godown_id' => $id);
        GodownZip::where($whereArray)->delete();
        
        $array_zip = explode(',', rtrim($request->get('zip'), ','));
        foreach ($array_zip as $zip) {
            $godown_zip = new GodownZip([
                'godown_id' => $id,
                'zip_code' => trim($zip)
            ]);
            $godown_zip->save();
        }

        return redirect('/admin/godown')->with('success', 'Godown Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $godown = Godown::find($id);
        $status = $godown->status == 1 ? 0 : 1;
        $godown->status =  $status;
        $godown->save();

        return redirect('/admin/godown')->with('success', 'Godown status updated!');
    }
}
