<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Province;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function supplierTable()
    {
        $userid = Auth::user()->id ?? 1;
        $data = Supplier::where('userid', $userid);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('alamat', function($data){
                $html = '';
                $html .= $data->province->province_name ?? '';
                $html .= '<br>'.$data->city->city_name ?? '';
                $html .= '<br>'.$data->district->subdistrict_name ?? '';

                return $html;
            })

            ->addColumn('status', function($data){
                if($data->status == 1) {
                    return '<div class="badge badge-pill border border-success text-success">Aktif</div>';
                } else {
                    return '<div class="badge badge-pill border border-danger text-red">Tidak Aktif</div>';
                }
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Delete Data" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="fa fa-trash fa-tombol-delete"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action','alamat','status'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'supplier';
        $userid = Auth::user()->id ?? 1;
        $branches = Branch::where('userid', $userid)->get();
        $provinces = Province::all();
        return view('frontend.settingan.supplier', compact('view','branches','provinces'));
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
        $input = $request->all();

        $rules = [
            'branch_id' => 'required',
            'nama_lengkap' => 'required',
            'customer_type' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'phone' => 'required',
            'email' => 'required',

        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $pesan = $validator->errors();
            $pesanarr = explode(',', $pesan);
            $find = ['[', ']', '{', '}'];
            $html = '';
            foreach ($pesanarr as $p) {
                $html .= str_replace($find, '', $p) . '<br>';
            }

            return response()->json([
                'success' => false,
                'message' => $html,
            ]);
        }

        try {

            $input['userid'] = Auth::user()->id ?? 1;
            $input['limit_hutang'] = str_replace('.', '', $input['limit_hutang'] ?? 0);

            Supplier::create($input);

            return response()->json([
                'success' => true,
                'message' => 'success',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
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
        $data = Supplier::find($id);
        return $data;
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
        $input = $request->all();

        $rules = [
            'branch_id' => 'required',
            'nama_lengkap' => 'required',
            'customer_type' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'phone' => 'required',
            'email' => 'required',

        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $pesan = $validator->errors();
            $pesanarr = explode(',', $pesan);
            $find = ['[', ']', '{', '}'];
            $html = '';
            foreach ($pesanarr as $p) {
                $html .= str_replace($find, '', $p) . '<br>';
            }

            return response()->json([
                'success' => false,
                'message' => $html,
            ]);
        }

        try {

            $data = Supplier::find($id);
            

            $input['userid'] = Auth::user()->id ?? 1;
            $input['limit_hutang'] = str_replace('.', '', $input['limit_hutang'] ?? 0);
            $data->update($input);

            return response()->json([
                'success' => true,
                'message' => 'success',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Supplier::destroy($id);
        return $data;
    }
}
