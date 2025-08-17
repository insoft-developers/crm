<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerAlamat;
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
            ->addColumn('balance', function ($data) {
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
            ->rawColumns(['action', 'customer_code'])
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
        return view('frontend.settingan.customer.index', compact('view', 'branches', 'provinces'));
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
            "nama_lengkap" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "phone" => "required|unique:customers,phone",
            "email" => "email|required|unique:customers,email",
            "customer_code" => "required|unique:customers,customer_code",
            "tanggal_aktif" => "required",
            "customer_type" => "required",
            "nama_tagihan" => "required",
            "kontak_tagihan" => "required",
            "alamat_tagihan" => "required",
            "provinsi" => "required",
            "kota" => "required",
            "kecamatan" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "account_owner" => "required",
            "bank_account_number" => "required",
            "bank_name" => "required",
            "bank_code" => "required",
            "branch_account" => "required",
            "npwp" => "required",
            "nama_pengiriman.*" => "required",
            "kontak_pengiriman.*" => "required",
            "alamat_pengiriman.*" => "required",
            "provinsi_pengiriman.*" => "required",
            "kota_pengiriman.*" => "required",
            "kecamatan_pengiriman.*" => "required",
            "latitude_pengiriman.*" => "required",
            "longitude_pengiriman.*" => "required"

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
            $userid = Auth::user()->id ?? 1;
            $input['userid'] = $userid;
            $customer_id = Customer::create($input)->id;

            $nama_pengiriman = $input['nama_pengiriman'];
            $kontak_pengiriman = $input['kontak_pengiriman'];
            $alamat_pengiriman = $input['alamat_pengiriman'];
            $provinsi_pengiriman = $input['provinsi_pengiriman'];
            $kota_pengiriman = $input['kota_pengiriman'];
            $kecamatan_pengiriman = $input['kecamatan_pengiriman'];
            $postal_code_pengiriman = $input['postal_code_pengiriman'];
            $latitude_pengiriman = $input['latitude_pengiriman'];
            $longitude_pengiriman = $input['longitude_pengiriman'];

            if (!empty($nama_pengiriman)) {
                foreach ($nama_pengiriman as $index => $nm) {
                    CustomerAlamat::create([
                        "customer_id" => $customer_id,
                        "userid" => $userid,
                        "nama" => $nm,
                        "kontak" => $kontak_pengiriman[$index],
                        "alamat" => $alamat_pengiriman[$index],
                        "province_id" => $provinsi_pengiriman[$index],
                        "city_id" => $kota_pengiriman[$index],
                        "district_id" => $kecamatan_pengiriman[$index],
                        "postal_code" => $postal_code_pengiriman[$index],
                        "latitude" => $latitude_pengiriman[$index],
                        "longitude" => $longitude_pengiriman[$index]
                    ]);
                }
            }

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
        $data['customer'] = Customer::find($id);
        $data['alamat'] = CustomerAlamat::where('customer_id', $id)->get();
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
            "nama_lengkap" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "phone" => "required|unique:customers,phone," . $id,
            "email" => "email|required|unique:customers,email," . $id,
            "customer_code" => "required|unique:customers,customer_code," . $id,
            "tanggal_aktif" => "required",
            "customer_type" => "required",
            "nama_tagihan" => "required",
            "kontak_tagihan" => "required",
            "alamat_tagihan" => "required",
            "provinsi" => "required",
            "kota" => "required",
            "kecamatan" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "account_owner" => "required",
            "bank_account_number" => "required",
            "bank_name" => "required",
            "bank_code" => "required",
            "branch_account" => "required",
            "npwp" => "required",
            "nama_pengiriman.*" => "required",
            "kontak_pengiriman.*" => "required",
            "alamat_pengiriman.*" => "required",
            "provinsi_pengiriman.*" => "required",
            "kota_pengiriman.*" => "required",
            "kecamatan_pengiriman.*" => "required",
            "latitude_pengiriman.*" => "required",
            "longitude_pengiriman.*" => "required"
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $html = implode('<br>', $validator->errors()->all());
            return response()->json([
                'success' => false,
                'message' => $html,
            ]);
        }

        try {
            $customer = Customer::find($id);
            $userid = Auth::user()->id ?? 1;

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                if ($customer->foto && file_exists(public_path('storage/customers/' . $customer->foto))) {
                    unlink(public_path('storage/customers/' . $customer->foto));
                }
                $unik = uniqid();
                $foto_name = Str::slug($unik, '-') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->move(public_path('storage/customers'), $foto_name);
                $input['foto'] = $foto_name;
            } else {
                $input['foto'] = $customer->foto;
            }

            $input['userid'] = $userid;

            $customer->update($input);

            // Ambil semua alamat lama
            $existingAlamatIds = $customer->alamat->pluck('id')->toArray(); // asumsi relasi alamat() sudah ada
            $submittedAlamatIds = $input['alamat_id'] ?? []; // input form harus ada hidden field alamat_id[]

            // Hapus alamat yang tidak ada di form
            $toDelete = array_diff($existingAlamatIds, $submittedAlamatIds);
            if (!empty($toDelete)) {
                CustomerAlamat::whereIn('id', $toDelete)->delete();
            }

            // Proses insert/update alamat
            if (!empty($input['nama_pengiriman'])) {
                foreach ($input['nama_pengiriman'] as $index => $nm) {
                    $alamatData = [
                        "customer_id" => $id,
                        "userid" => $userid,
                        "nama" => $nm,
                        "kontak" => $input['kontak_pengiriman'][$index],
                        "alamat" => $input['alamat_pengiriman'][$index],
                        "province_id" => $input['provinsi_pengiriman'][$index],
                        "city_id" => $input['kota_pengiriman'][$index],
                        "district_id" => $input['kecamatan_pengiriman'][$index],
                        "postal_code" => $input['postal_code_pengiriman'][$index] ?? null,
                        "latitude" => $input['latitude_pengiriman'][$index],
                        "longitude" => $input['longitude_pengiriman'][$index]
                    ];

                    if (!empty($submittedAlamatIds[$index])) {
                        // update jika alamat_id ada
                        CustomerAlamat::where('id', $submittedAlamatIds[$index])->update($alamatData);
                    } else {
                        // insert baru
                        CustomerAlamat::create($alamatData);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Customer berhasil diupdate',
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

    public function kotaGet(Request $request)
    {
        $input = $request->all();

        $data = Kota::where('province_id', $input['province_id'])->get();
        return $data;
    }


    public function kecamatanGet(Request $request)
    {
        $input = $request->all();

        $data = Kecamatan::where('city_id', $input['city_id'])->get();
        return $data;
    }
}
