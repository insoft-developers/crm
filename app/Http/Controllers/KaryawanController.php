<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\KaryawanDocument;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function karyawanTable()
    {
        $userid = Auth::user()->id ?? 1;
        $data = Karyawan::where('userid', $userid);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nik', function ($data) {
                return '<a onclick="detailData('.$data->id.')" href="javascript:void(0);"><div class="karyawan-id">' . $data->nik . '</div></a>';
            })
            ->addColumn('alamat', function ($data) {
                $html = '';
                $html .= $data->province->province_name ?? '';
                $html .= '<br>' . $data->city->city_name ?? '';
                $html .= '<br>' . $data->district->subdistrict_name ?? '';

                return $html;
            })
            ->addColumn('tanggal_masuk', function ($data) {
                return date('d-m-Y', strtotime($data->tanggal_masuk));
            })

            ->addColumn('updated_at', function ($data) {
                return date('d-m-Y H:i', strtotime($data->updated_at));
            })

            ->addColumn('branch_id', function ($data) {
                return $data->branch->branch_name ?? '';
            })
            ->addColumn('jabatan', function ($data) {
                return $data->jabatans->jabatan_name ?? '';
            })
            ->addColumn('departemen', function ($data) {
                return $data->department->department_name ?? '';
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Delete Data" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="fa fa-trash fa-tombol-delete"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action', 'alamat', 'nik'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'karyawan';
        $userid = Auth::user()->id ?? 1;
        $branches = Branch::where('userid', $userid)->get();
        $departments = Department::where('userid', $userid)->get();
        $jabatans = Jabatan::where('userid', $userid)->get();
        $provinces = Province::all();
        return view('frontend.settingan.karyawan.index', compact('view', 'branches', 'provinces', 'departments', 'jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

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
            'nik' => 'required|unique:karyawans,nik',
            'departemen' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'phone' => 'required|unique:karyawans,phone',
            'email' => 'email|required|unique:karyawans,email',
            'latitude' => 'required',
            'longitude' => 'required',
            'tanggal_masuk' => 'required',
            'username' => 'nullable|unique:karyawans,username',
            'password' => 'nullable|required_with:username|min:6',
            'document_name.*' =>  'required',
            'document_number.*' => 'required',
            'account_owner' => 'required',
            'bank_account_number' => 'required',
            'bank_name' => 'required',
            'bank_code' => 'required',
            'branch_account' => 'required',
            
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
                $request->foto->move(public_path('/storage/karyawan'), $input['foto']);
            }
            $userid = Auth::user()->id ?? 1;
            $input['userid'] = $userid;

            $uid = Karyawan::create($input)->id;

            if (! empty($input['document_name'])) {
                foreach ($input['document_name'] as $index => $dn) {

                    $input['document_image'][$index] = null;
                    $unik = uniqid();

                    // Cek apakah file di index ini ada
                    if ($request->hasFile('document_image') && isset($request->file('document_image')[$index])) {
                        $file = $request->file('document_image')[$index];
                        $filename = Str::slug($unik, '-') . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('/storage/documents'), $filename);
                        $input['document_image'][$index] = $filename;
                    }

                    KaryawanDocument::create([
                        "document_name"   => $dn,
                        "document_number" => $input['document_number'][$index] ?? null,
                        "document_image"  => $input['document_image'][$index],
                        "karyawan_id" => $uid,
                        "userid" => $userid
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
        $emp = Karyawan::find($id);
        $doc = KaryawanDocument::where('karyawan_id', $id)->get();
        
        $html = '';
        $html .= '<div class="row">';
        $html .= '<div class="col-2">';
        if($emp->foto == null) {
            $html .= '<img id="profile-image" class="profile-image-upload"
                                        src="'.asset('images/avatar_foto.webp').'">';
        } else {
            $html .= '<img id="profile-image" class="profile-image-upload"
                                        src="'.asset('storage/karyawan/'.$emp->foto).'">';
        }
        
        $html .= '</div>';

        $html .= '<div class="col-5">';
        $html .= '<div class="row">';

        $html .= '<div class="col-12">';
        $html .= '<table class="table-compact">';
        
        $html .= '<tr>';
        $html .= '<td width="10%">Nama</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="38%">'.$emp->nama_lengkap.'</td>';

        $html .= '<td width="10%">Gender</td>';
        $html .= '<td width="2%">:</td>';
        $html .= '<td width="38%">'.$emp->jenis_kelamin.'</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Tempat/Tgl Lahir</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->tempat_lahir.'/'.date('d-m-Y', strtotime($emp->tanggal_lahir)).'</td>';

        $html .= '<td>Agama</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->agama.'</td>';

        $html .= '</tr>';


        $html .= '<tr>';
        $html .= '<td>Email</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->email.'</td>';

        $html .= '<td>Telepon</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->phone.'</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Alamat</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->alamat.'</td>';

        $html .= '<td>Kecamatan</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->district->subdistrict_name ?? ''.'</td>';

        $html .= '</tr>';

       

        $html .= '<tr>';
        $html .= '<td>Kabupaten/Kota</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->city->city_name ?? ''.'</td>';

        $html .= '<td>Provinsi</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->province->province_name.'</td>';

        $html .= '</tr>';

        

        $html .= '<tr>';
        $html .= '<td>Kode Pos</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->postal_code.'</td>';

        $html .= '<td></td>';
        $html .= '<td></td>';
        $html .= '<td></td>';


        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Latitude</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->latitude.'</td>';

        $html .= '<td>Longitude</td>';
        $html .= '<td>:</td>';
        $html .= '<td>'.$emp->longitude.'</td>';


        $html .= '</tr>';


        $html .= '<tr>';
        $html .= '<td colspan="6"> <div id="map-detail" style="height: 200px;"></div></td>';
        
        $html .= '</tr>';


       


        $html .= '</table>';
        $html .= '</div>'; 

        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="col-5">';
        $html .= '</div>';

        $html .= '</div>';


        $data['html'] = $html;
        $data['emp'] = $emp;
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
        $data['karyawan'] = Karyawan::find($id);
        $data['document'] = KaryawanDocument::where('karyawan_id', $id)->get();
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
            'nik' => 'required|' . Rule::unique('karyawans', 'nik')->ignore($id),
            'departemen' => 'required',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'phone' => 'required|' . Rule::unique('karyawans', 'phone')->ignore($id),
            'email' => 'email|required|' . Rule::unique('karyawans', 'email')->ignore($id),
            'latitude' => 'required',
            'longitude' => 'required',
            'tanggal_masuk' => 'required',
            'username' => 'nullable|' . Rule::unique('karyawans', 'username')->ignore($id),
            'password' => 'nullable|required_with:username|min:6',
            'document_name.*' =>  'required',
            'document_number.*' => 'required',
            'account_owner' => 'required',
            'bank_account_number' => 'required',
            'bank_name' => 'required',
            'bank_code' => 'required',
            'branch_account' => 'required',

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

            $data = Karyawan::find($id);
            // upload profile foto
            $input['foto'] = $data->foto;
            $unik = uniqid();
            if ($request->hasFile('foto')) {
                $input['foto'] = Str::slug($unik, '-') . '.' . $request->foto->getClientOriginalExtension();
                $request->foto->move(public_path('/storage/karyawan'), $input['foto']);
            }

            $userid = Auth::user()->id ?? 1;
            $input['userid'] = $userid;
            $data->update($input);


            if (!empty($input['document_name'])) {
                // Ambil semua ID dokumen lama untuk karyawan ini
                $oldDocs = KaryawanDocument::where('karyawan_id', $id)->get();

                // Simpan semua ID dokumen yang masih ada di request
                $keptIds = [];

                foreach ($input['document_name'] as $index => $dn) {

                    // Skip kalau document_name kosong
                    if (empty($dn)) {
                        continue;
                    }

                    $documentId = $input['document_id'][$index] ?? null;
                    $existingDoc = $documentId ? KaryawanDocument::find($documentId) : null;

                    $filename = $existingDoc->document_image ?? null;

                    if ($request->hasFile("document_image.$index")) {
                        $unik = uniqid();
                        $file = $request->file("document_image.$index");
                        $filename = Str::slug($unik, '-') . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('/storage/documents'), $filename);

                        if ($existingDoc && $existingDoc->document_image && file_exists(public_path('/storage/documents/' . $existingDoc->document_image))) {
                            unlink(public_path('/storage/documents/' . $existingDoc->document_image));
                        }
                    }

                    if ($existingDoc) {
                        $existingDoc->update([
                            "document_name"   => $dn,
                            "document_number" => $input['document_number'][$index] ?? null,
                            "document_image"  => $filename,
                        ]);
                        $keptIds[] = $existingDoc->id;
                    } else {
                        $newDoc = KaryawanDocument::create([
                            "document_name"   => $dn,
                            "document_number" => $input['document_number'][$index] ?? null,
                            "document_image"  => $filename,
                            "karyawan_id"     => $id,
                            "userid"          => $userid
                        ]);
                        $keptIds[] = $newDoc->id;
                    }
                }

                // Hapus dokumen lama yang tidak ada di keptIds
                foreach ($oldDocs as $doc) {
                    if (!in_array($doc->id, $keptIds)) {
                        // Hapus file fisik kalau ada
                        if ($doc->document_image && file_exists(public_path('/storage/documents/' . $doc->document_image))) {
                            unlink(public_path('/storage/documents/' . $doc->document_image));
                        }
                        $doc->delete();
                    }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Karyawan::destroy($id);
        return $data;
    }


    public function formAddKaryawan(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id ?? 1;
        $branch = Branch::create([
            "branch_name" => $input['branch_name'],
            "userid" => $userid
        ]);

        if ($branch) {
            $data = Branch::where('userid', $userid)->get();
            return response()->json([
                "success" => true,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ]);
        }
    }



    public function formAddJabatan(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id ?? 1;
        $jabatan = Jabatan::create([
            "jabatan_name" => $input['jabatan_name'],
            "userid" => $userid
        ]);

        if ($jabatan) {
            $data = Jabatan::where('userid', $userid)->get();
            return response()->json([
                "success" => true,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ]);
        }
    }


    public function formAddDepartment(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id ?? 1;
        $department = Department::create([
            "department_name" => $input['department_name'],
            "userid" => $userid
        ]);

        if ($department) {
            $data = Department::where('userid', $userid)->get();
            return response()->json([
                "success" => true,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "data" => []
            ]);
        }
    }
}
