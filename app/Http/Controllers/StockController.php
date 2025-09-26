<?php

namespace App\Http\Controllers;

use App\Models\GoodReceiveItem;
use App\Models\Location;
use App\Models\StockReturnDetail;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    use CommonTrait;
    public function stockTable(Request $request)
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $query = GoodReceiveItem::where('userid', $userid)->whereHas('goodReceive', function ($q) {
            $q->where('good_status', 1);
        });

        if ($request->product_name_filter) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('product_name', 'like', '%'.$request->product_name_filter.'%');
            });
        }

        // filter status
        if ($request->coil_number_filter) {
            $query->where('coil_number', 'like', '%'.$request->coil_number_filter.'%');
        }

        if ($request->product_number_filter) {
            $query->where('product_number', 'like', '%'.$request->product_number_filter.'%');
        }

        if ($request->tebal_filter) {
            $query->where('tebal', 'like', '%'.$request->tebal_filter.'%');
        }

        $data = $query->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('mills', function ($row) {
                return $row->goodReceive->mills ?? '';
            })
            ->addColumn('product_id', function ($row) {
                return $row->product->product_name ?? '';
            })
            ->addColumn('tebal_actual', function ($row) {
                return $row->tebal_actual === null ? '<span style="color:red;">Not Inspected</span>' : $row->tebal_actual;
            })
            ->addColumn('weight_actual', function ($row) {
                return $row->weight_actual === null ? '<span style="color:red;">Not Inspected</span>' : number_format($row->weight_actual);
            })
            ->addColumn('weight_received', function ($row) {
                return number_format($row->weight_received);
            })
            ->addColumn('stock_status', function ($row) {
                if ($row->stock_status == 1) {
                    return '<div style="color:blue;">Booked</div>';
                } elseif ($row->stock_status == 2) {
                    return '<div style="color:red;">Returned</div>';
                } else {
                    return '<div style="color:orange;">Available</div>';
                }
            })

            ->addColumn('note', function ($row) {
                return $row->note == null ? ' - ' : $row->note;
            })

            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a title="Edit Stock" href="javascript:void(0);" onclick="editData(' . $row->id . ', 1)" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Return Stock" href="javascript:void(0);" onclick="editData(' . $row->id . ', 2)"><i class="fa fa-trash fa-tombol-delete"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action', 'tebal_actual', 'weight_actual', 'stock_status'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::where('userid', $this->set_owner_id(Auth::user()->id))->get();
        return view('frontend.stock.index',compact('locations'));
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
        //
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
        $data = GoodReceiveItem::with('product', 'goodReceive', 'retur')->find($id);
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
        
        $aksi = $input['aksi'];

        if ($aksi == 'retur') {
            $rules = [
                'return_note' => 'array|required',
                'return_note.*' => 'nullable|string',
                'return_image' => 'array',
                'return_image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

            
            $notes = $input['return_note'] ?? [];
            $listId = $input['list_id'] ?? []; // hidden input berisi id lama (bisa null)
            $images = $request->file('return_image', []); // array file (bisa kosong)

            // --- 1. Hapus record yang tidak lagi ada di form ---
            $existingIds = StockReturnDetail::where('stock_id', $id)->pluck('id')->toArray();
            $idsToDelete = array_diff($existingIds, $listId); // id yg ada di DB tapi tidak dikirim
            foreach ($idsToDelete as $delId) {
                $detail = StockReturnDetail::find($delId);
                if ($detail) {
                    
                    $detail->delete();
                }
            }

            // --- 2. Insert / Update ---
            foreach ($notes as $index => $note) {
                $currentId = $listId[$index] ?? null;
                $path = null;

                // cek apakah user mengunggah gambar baru di index ini
                if (!empty($images[$index])) {
                    $path = $images[$index]->store('return', 'public');
                }

                if ($currentId) {
                    // update record lama
                    $detail = StockReturnDetail::find($currentId);
                    if ($detail) {
                        $updateData = ['note' => $note];
                        if ($path) {
                            $updateData['return_image'] = $path;
                        }
                        $detail->update($updateData);
                    }
                } else {
                    // insert record baru
                    StockReturnDetail::create([
                        'note' => $note,
                        'return_image' => $path,
                        'stock_id' => $id,
                        'userid' => $this->set_owner_id(Auth::user()->id),
                    ]);
                }
            }

            GoodReceiveItem::where('id', $id)->update([
                'stock_status' => 2,
                'return_date' => Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'success',
            ]);
        } else {
            $data = GoodReceiveItem::find($id);
            $data->tebal_actual = $input['tebal_actual'];
            $data->weight_actual = $input['weight_actual'];
            $data->note = $input['note'];
            $data->remark = $input['remark'];
            $data->location = $input['location'];
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'success',
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
        //
    }
}
