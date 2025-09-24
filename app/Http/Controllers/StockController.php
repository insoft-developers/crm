<?php

namespace App\Http\Controllers;

use App\Models\GoodReceiveItem;
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
    public function stockTable()
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $data = GoodReceiveItem::where('userid', $userid)->whereHas('goodReceive', function ($q) {
            $q->where('good_status', 1);
        });
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
        return view('frontend.stock.index');
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
        $data = GoodReceiveItem::with('product', 'goodReceive','retur')->find($id);
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

            $notes = $input['return_note'];
            $images = $request->file('return_image', []); // bisa saja kosong

            foreach ($notes as $index => $note) {
                $path = null;

                // jika ada file gambar di index yg sama
                if (!empty($images[$index])) {
                    // simpan ke storage/app/public/returns
                    $path = $images[$index]->store('return', 'public');
                }

                StockReturnDetail::create([
                    'note' => $note,
                    'return_image' => $path, // bisa null jika tak ada gambar
                    'stock_id' => $id, // contoh relasi
                    'userid' => $this->set_owner_id(Auth::user()->id),
                ]);
            }

            GoodReceiveItem::where('id', $id)->update([
                "stock_status" => 2,
                "return_date" => Carbon::now()
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
