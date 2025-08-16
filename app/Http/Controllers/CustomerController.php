<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class CustomerController extends Controller
{
    
    
    
    public function customerTable()
    {
        $userid = Auth::user()->id ?? 1;
        $data = Customer::where('userid', $userid);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('customer_code', function ($data) {
                return '<a onclick="detailData(' . $data->id . ')" href="javascript:void(0);"><div class="karyawan-id">' . $data->customer_code . '</div></a>';
            })
            ->addColumn('balance', function($data){
                return number_format($data->balance);
            })
            
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Delete Data" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="fa fa-trash fa-tombol-delete"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action','customer_code'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'customer';
        $userid = Auth::user()->id ?? 1;
        $branches = Branch::where('userid', $userid)->get();
        $provinces = Province::all();
        return view('frontend.settingan.customer.index', compact('view','branches','provinces'));
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

            // upload profile foto
            $input['foto'] = null;
            $unik = uniqid();
            if ($request->hasFile('foto')) {
                $input['foto'] = Str::slug($unik, '-') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->move(public_path('/storage/customers'), $input['foto']);
            }

            $input['userid'] = Auth::user()->id ?? 1;
            $input['limit_hutang'] = str_replace('.', '', $input['limit_hutang'] ?? 0);

            Customer::create($input);

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
        $data = Customer::find($id);
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

            $data = Customer::find($id);
            // upload profile foto
            $input['foto'] = $data->foto;
            $unik = uniqid();
            if ($request->hasFile('foto')) {
                $input['foto'] = Str::slug($unik, '-') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->move(public_path('/storage/customers'), $input['foto']);
            }

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
        $data = Customer::destroy($id);
        return $data;
    }

    public function kotaGet(Request $request) {
        $input = $request->all();

        $data = Kota::where('province_id', $input['province_id'])->get();
        return $data;
    }


    public function kecamatanGet(Request $request) {
        $input = $request->all();

        $data = Kecamatan::where('city_id', $input['city_id'])->get();
        return $data;
    }
}