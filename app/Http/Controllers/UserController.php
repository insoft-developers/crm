<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use App\Models\UserPosition;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use CommonTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function userTable()
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $data = User::where('owner_id', $userid)->where('id', '!=', $userid);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('position_id', function ($row) {
                return $row->rposition->position_name ?? '';
            })
            ->addColumn('user_level', function ($row) {
                return $row->rlevel->level_name ?? '';
            })
            ->addColumn('approve_1', function ($row) {
                if ($row->approve_1 == 1 && $row->approve_2 == 0) {
                    return 'Pertama';
                } elseif ($row->approve_1 == 0 && $row->approve_2 == 1) {
                    return 'Kedua';
                } elseif ($row->approve_1 == 0 && $row->approve_2 == 0) {
                    return 'Tidak ada';
                }
            })
            ->addColumn('is_active', function ($row) {
                return $row->is_active == 1 ? 'Aktif' : 'Tidak Aktif';
            })

            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div><center>';

                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Delete Data" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="fa fa-trash fa-tombol-delete"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        $levels = UserLevel::all();
        $positions = UserPosition::where('id', '!=', 1)->get();
        return view('frontend.user.index', compact('levels', 'positions'));
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
            'first_name' => 'required',
            'password' => 'required|min:6',
            'email' => 'email|required|unique:users,email',
            'phone_number' => 'numeric|required|unique:users,phone_number',
            'user_level' => 'required',
            'position_id' => 'required',
            'approve_level' => 'required',
            'is_active' => 'required',
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
            $userid = $this->set_owner_id(Auth::user()->id);
            $user = User::find($userid);

            $input['name'] = $input['first_name'] . ' ' . $input['last_name'];
            $input['email_verified_at'] = $user->email_verified_at;
            $input['password'] = bcrypt($request->password);
            $input['company_name'] = $user->company_name;
            $input['city'] = $user->city;
            $input['leader_name'] = $user->leader_name;
            $input['company_address'] = $user->company_address;
            $input['company_type'] = $user->company_type;
            $input['owner_id'] = $user->id;
            $input['approve_1'] = $request->approve_level == 1 ? 1 : 0;
            $input['approve_2'] = $request->approve_level == 2 ? 1 : 0;

            User::create($input);

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
        $data = User::find($id);
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

        // === Cari user yang akan di-update ===
        $user = User::findOrFail($id);

        // === Rules validasi ===
        $rules = [
            'first_name' => 'required',
            'password' => 'nullable|min:6', // password boleh kosong saat update
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|numeric|unique:users,phone_number,' . $user->id,
            'user_level' => 'required',
            'position_id' => 'required',
            'approve_level' => 'required|in:1,2',
            'is_active' => 'required|boolean',
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode('<br>', $validator->errors()->all()),
            ]);
        }

        try {
            // === Persiapkan data yang diupdate ===
            $data = [
                'name' => $request->first_name . ' ' . ($request->last_name ?? ''),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'user_level' => $request->user_level,
                'position_id' => $request->position_id,
                'is_active' => $request->is_active,
                'approve_1' => $request->approve_level == 1 ? 1 : 0,
                'approve_2' => $request->approve_level == 2 ? 1 : 0,
            ];

            // Password hanya di-update jika diisi
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            // === Update ===
            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diperbarui.',
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
        return User::destroy($id);
    }
}
