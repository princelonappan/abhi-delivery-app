<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaletInventory;
use App\User;
use App\Product;
use App\Godown;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;


class PaletInventoryController extends Controller
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
        $godown_unique_id = $request->godown_unique_id;
        $godowns = Godown::where('status', 1)->get();
        $palet_inventory = PaletInventory::orderBy('created_at', 'desc');
        if ($request->wantsJson) {
            if(!empty($godown_unique_id)) {
                $palet_inventory = $palet_inventory->where('godown_id', $godown_unique_id);
            }
            $palet_inventory = $palet_inventory->get();
            return $palet_inventory;
        } else {
            if(!empty($godown_unique_id)) {
                $palet_inventory = $palet_inventory->where('godown_id', $godown_unique_id);
            }
            $palet_inventory = $palet_inventory->paginate(10);;
            return view('admin.palet_inventory.list-palet_inventory')->with(['palet_inventory' => $palet_inventory, 'godowns' => $godowns, 'godown_unique_id' => $godown_unique_id]);
        }
    }

    public function download()
    {
        $file = public_path() . "/downloads/sample.csv";
        $headers = array(
            'Content-Type: text/csv',
        );
        return Response::download($file, 'sample.csv', $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'csv_import' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_import');
        $filename = time() . $file->getClientOriginalName();
        $location = 'uploads/csv';
        $file->move($location, $filename);
        $filepath = public_path($location . "/" . $filename);
        $file = fopen($filepath, "r");
        $import_data = array();
        $i = 0;

        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            if ($i == 0) {
                $i++;
                continue;
            }
            for ($c = 0; $c < $num; $c++) {
                $import_data[$i][] = $filedata[$c];
            }
            $i++;
        }
        fclose($file);
        $saved_count = 0;
        foreach ($import_data as $data) {
            if (isset($data) && $data[0] && $data[1] && $data[2]) {
                $godown_id = $data[0];
                $product_id = $data[1];
                $palet_id = $data[2];
                $palet_inventory = PaletInventory::where([
                    'godown_id' => $godown_id,
                    'palet_id' => $palet_id, 'product_id' => $product_id
                ])->first();
                $product = Product::find($product_id);
                $godown = Godown::where([
                    'godown_unique_id' => $godown_id
                ])->first();

                if (empty($palet_inventory) && !empty($product) && !empty($godown)) {
                    $saved_count++;
                    $response = PaletInventory::create([
                        'godown_id' => $godown_id,
                        'palet_id' => $palet_id,
                        'product_id' => $product_id,
                        'available' => 1
                    ]);
                }
            }
        }
        return redirect('/admin/palet-inventory')->with('success', 'Sucessfully saved '.$saved_count.' records.');
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
    public function destroy($id)
    {
    }
}
