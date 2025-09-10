<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerAlamat;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Province;
use App\Models\Vendor;
use App\Models\VendorAlamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class VendorController extends Controller
{



    public function vendorTable()
    {
        $userid = Auth::user()->id ?? 1;
        $data = Vendor::where('userid', $userid);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('vendor_code', function ($data) {
                return '<a onclick="detailData(' . $data->id . ')" href="javascript:void(0);"><div class="karyawan-id">' . $data->vendor_code . '</div></a>';
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
            ->rawColumns(['action', 'vendor_code'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'vendor';
        $userid = Auth::user()->id ?? 1;
        $branches = Branch::where('userid', $userid)->get();
        $provinces = Province::all();
        return view('frontend.settingan.vendor.index', compact('view', 'branches', 'provinces'));
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
            "vendor_name" => "required",
            "phone" => "required|unique:vendors,phone",
            "email" => "email|required|unique:vendors,email",
            "vendor_code" => "required|unique:vendors,vendor_code",
            "tanggal_aktif" => "required",
            "vendor_type" => "required",
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
            "longitude_pengiriman.*" => "required",
            "status" => "required",
            "vendor_grade" => "required"
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
                $request->foto->move(public_path('/storage/vendors'), $input['foto']);
            }
            $userid = Auth::user()->id ?? 1;
            $input['userid'] = $userid;
            $vendor_id = Vendor::create($input)->id;

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
                    VendorAlamat::create([
                        "vendor_id" => $vendor_id,
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
        $cust = Vendor::find($id);
        $alamats = VendorAlamat::where('vendor_id', $id)->get();
        $html = '';

        $html .= '<div class="row">';
        $html .= '<div class="col-12">';
        $html .= '<div class="card">';
        $html .= '<div class="card-body">';
        $html .= '<div class="card-title">Info Dasar</div>';
        $html .= '<div class="row">';
        $html .= '<div class="col-2">';
        if ($cust->foto == null) {
            $html .= '<img id="profile-image" class="profile-image-upload"
                                        src="' . asset('images/avatar_foto.webp') . '">';
        } else {
            $html .= '<img id="profile-image" class="profile-image-upload"
                                        src="' . asset('storage/vendors/' . $cust->foto) . '">';
        }
        $html .= '</div>'; //col2
        $html .= '<div class="col-5">';
        $html .= '<table class="table-compact">';

        $html .= '<tr>';
        $html .= '<td width="20%">Nama</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%">' . $cust->vendor_name . '</td>';

        $html .= '<td width="20%">Tanggal Aktif</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%">' . date('d-m-Y', strtotime($cust->tanggal_aktif)) . '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td width="20%">Tanggal Lahir</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%"></td>';

        $html .= '<td width="20%">Tipe Vendor</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%">' . $cust->vendor_type . '</td>';
        $html .= '</tr>';



        $html .= '<tr>';
        $html .= '<td width="20%">Kontak</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%">' . $cust->phone . '</td>';

        $html .= '<td width="20%">Status</td>';
        $html .= '<td width="2%">:</td>';
        $status = $cust->status === 1 ? 'Aktif' : 'Tidak Aktif';

        $html .= '<td width="28%">' . $status . '</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td width="20%">Email</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%">' . $cust->email . '</td>';

        $html .= '<td width="20%">Grade</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="28%">' . $cust->vendor_grade . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</div>'; //col10
        $html .= '</div>'; //col2
        $html .= '</div>'; //row
        $html .= '</div>'; //card body
        $html . '</div>'; //card
        $html .= '</div>'; //col12
        $html .= '</div>'; //row
        $html .= '</div>'; //row



        $at = '';

        $at .= '<table class="table-compact">';

        $at .= '<tr>';
        $at .= '<td width="20%">Nama</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->nama_tagihan . '</td>';

        $at .= '<td width="20%">Kontak</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->kontak_tagihan . '</td>';
        $at .= '</tr>';

        $at .= '<tr>';
        $at .= '<td width="20%">Alamat</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->alamat_tagihan . '</td>';

        $at .= '<td width="20%"></td>';
        $at .= '<td width="2%"></td>';
        $at .= '<td width="28%"></td>';
        $at .= '</tr>';



        $at .= '<tr>';
        $at .= '<td width="20%">Provinsi</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->province->province_name ?? '' . '</td>';

        $at .= '<td width="20%">Kabupaten/Kota</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->city->city_name ?? '' . '</td>';
        $at .= '</tr>';

        $at .= '<tr>';
        $at .= '<td width="20%">Kecamatan</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->district->subdistrict_name ?? '' . '</td>';

        $at .= '<td width="20%">Kode Pos</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->postal_code . '</td>';
        $at .= '</tr>';

        $at .= '<tr>';
        $at .= '<td width="20%">Latitude</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->latitude . '</td>';

        $at .= '<td width="20%">Longitude</td>';
        $at .= '<td width="2%">:</td>';
        $at .= '<td width="28%">' . $cust->longitude . '</td>';
        $at .= '</tr>';

        $at .= '<tr>';
        $at .= '<td colspan="6"><div id="map-detail" style="height: 200px;"></div></td>';

        $at .= '</tr>';
        $at .= '</table>';


        $ac = '';

        $ac .= '<table class="table-compact">';

        $ac .= '<tr>';
        $ac .= '<td width="20%">Pemegang Kartu</td>';
        $ac .= '<td width="2%">:</td>';
        $ac .= '<td width="28%">' . $cust->account_owner . '</td>';

        $ac .= '<td width="20%">Nomor Rekening</td>';
        $ac .= '<td width="2%">:</td>';
        $ac .= '<td width="28%">' . $cust->bank_account_number . '</td>';
        $ac .= '</tr>';

        $ac .= '<tr>';
        $ac .= '<td width="20%">Nama Bank</td>';
        $ac .= '<td width="2%">:</td>';
        $ac .= '<td width="28%">' . $cust->bank_name . '</td>';

        $ac .= '<td width="20%">Nomor Kode Bank</td>';
        $ac .= '<td width="2%">:</td>';
        $ac .= '<td width="28%">' . $cust->bank_code . '</td>';
        $ac .= '</tr>';



        $ac .= '<tr>';
        $ac .= '<td width="20%">Lokasi Bank</td>';
        $ac .= '<td width="2%">:</td>';
        $ac .= '<td width="28%">' . $cust->branch_account . '</td>';

        $ac .= '<td width="20%">NPWP</td>';
        $ac .= '<td width="2%">:</td>';
        $ac .= '<td width="28%">' . $cust->npwp . '</td>';
        $ac .= '</tr>';

        $ac .= '</table>';




        $tj = '';

        $tj .= '<table class="table-compact">';

        $tj .= '<tr>';
        $tj .= '<td width="20%">Nama</td>';
        $tj .= '<td width="2%">:</td>';
        $tj .= '<td width="28%">' . $cust->nama_penanggung_jawab . '</td>';

        $tj .= '<td width="20%">Jabatan</td>';
        $tj .= '<td width="2%">:</td>';
        $tj .= '<td width="28%">' . $cust->jabatan_penanggung_jawab . '</td>';
        $tj .= '</tr>';

        $tj .= '<tr>';
        $tj .= '<td width="20%">Kontak</td>';
        $tj .= '<td width="2%">:</td>';
        $tj .= '<td width="28%">' . $cust->kontak_penanggung_jawab . '</td>';

        $tj .= '<td width="20%">Email</td>';
        $tj .= '<td width="2%">:</td>';
        $tj .= '<td width="28%">' . $cust->email_penanggung_jawab . '</td>';
        $tj .= '</tr>';

        $tj .= '</table>';

        $ap = '';
        foreach ($alamats as $index => $al) {

            $baris = $index + 1;
            $ap .= '<div class="row">';
            $ap .= '<div class="col-12">';

            $ap .= '<div class="card">';
            $ap .= '<div class="card-body">';
            $ap .= '<div class="row">';
            $ap .= '<div class="col-6">';

            $ap .= '<table class="table-compact">';

            $ap .= '<tr>';
            $ap .= '<td width="20%">Nama</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->nama . '</td>';

            $ap .= '<td width="20%">Kontak</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->kontak . '</td>';
            $ap .= '</tr>';

            $ap .= '<tr>';
            $ap .= '<td width="20%">Alamat</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->alamat . '</td>';

            $ap .= '<td width="20%"></td>';
            $ap .= '<td width="2%"></td>';
            $ap .= '<td width="28%"></td>';
            $ap .= '</tr>';


            $ap .= '<tr>';
            $ap .= '<td width="20%">Provinsi</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->province->province_name ?? '' . '</td>';

            $ap .= '<td width="20%">Kabupaten/Kota</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->city->city_name ?? '' . '</td>';
            $ap .= '</tr>';


            $ap .= '<tr>';
            $ap .= '<td width="20%">Kecamatan</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->district->subdistrict_name ?? '' . '</td>';

            $ap .= '<td width="20%">Kode Pos</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->postal_code . '</td>';
            $ap .= '</tr>';


            $ap .= '<tr>';
            $ap .= '<td width="20%">Latitude</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->latitude . '</td>';

            $ap .= '<td width="20%">Longitude</td>';
            $ap .= '<td width="2%">:</td>';
            $ap .= '<td width="28%">' . $al->longitude . '</td>';
            $ap .= '</tr>';

            $ap .= '</table>';
            $ap .= '</div>';

            $ap .= '<div class="col-6">';
            $ap .= '<div id="map_'.$baris.'" style="height: 200px;"></div>';
            $ap .= '</div>';
            $ap .= '</div>';
            
            $ap .= '</div>';
            $ap .= '</div>';
            $ap .= '</div>';
            $ap .= '</div>';
        }


        $data['alamat_pengiriman'] = $ap;
        $data['cust'] = $cust;
        $data['alamat_tagihan'] = $at;
        $data['account_detail'] = $ac;
        $data['tanggung_jawab'] = $tj;
        $data['html'] = $html;
        $data['alamat'] = $alamats;

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['customer'] = Vendor::find($id);
        $data['alamat'] = VendorAlamat::where('vendor_id', $id)->get();
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
            "vendor_name" => "required",
            "phone" => "required|unique:vendors,phone," . $id,
            "email" => "email|required|unique:vendors,email," . $id,
            "vendor_code" => "required|unique:vendors,vendor_code," . $id,
            "tanggal_aktif" => "required",
            "vendor_type" => "required",
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
            "longitude_pengiriman.*" => "required",
            "status" => "required",
            "vendor_grade" => "required"
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
            $customer = Vendor::find($id);
            $userid = Auth::user()->id ?? 1;

            // Upload foto jika ada
            if ($request->hasFile('foto')) {
                if ($customer->foto && file_exists(public_path('storage/vendors/' . $customer->foto))) {
                    unlink(public_path('storage/vendors/' . $customer->foto));
                }
                $unik = uniqid();
                $foto_name = Str::slug($unik, '-') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->move(public_path('storage/vendors'), $foto_name);
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
                VendorAlamat::whereIn('id', $toDelete)->delete();
            }

            // Proses insert/update alamat
            if (!empty($input['nama_pengiriman'])) {
                foreach ($input['nama_pengiriman'] as $index => $nm) {
                    $alamatData = [
                        "vendor_id" => $id,
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
                        VendorAlamat::where('id', $submittedAlamatIds[$index])->update($alamatData);
                    } else {
                        // insert baru
                        VendorAlamat::create($alamatData);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Vendor berhasil diupdate',
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
        VendorAlamat::where('vendor_id', $id)->delete();
        $data = Vendor::destroy($id);
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
