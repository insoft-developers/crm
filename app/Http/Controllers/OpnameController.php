<?php

namespace App\Http\Controllers;

use App\Models\GoodReceiveItem;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OpnameController extends Controller
{
    use CommonTrait;
    public function opnameTable(Request $request)
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $query = GoodReceiveItem::where('userid', $userid);

        if ($request->product_name_filter) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->product_name_filter . '%');
            });
        }

        // filter status
        if ($request->coil_number_filter) {
            $query->where('coil_number', 'like', '%' . $request->coil_number_filter . '%');
        }

        if ($request->product_number_filter) {
            $query->where('product_number', 'like', '%' . $request->product_number_filter . '%');
        }

        if ($request->tebal_filter) {
            $query->where('tebal', 'like', '%' . $request->tebal_filter . '%');
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
            ->addColumn('tebal_fisik', function ($row) {
                return $row->tebal_fisik === null ? '<span style="color:red;">Not Inspected</span>' : $row->tebal_fisik;
            })
            ->addColumn('weight_actual', function ($row) {
                return $row->weight_actual === null ? '<span style="color:red;">Not Inspected</span>' : number_format($row->weight_actual);
            })
            ->addColumn('weight_fisik', function ($row) {
                return $row->weight_fisik === null ? '<span style="color:red;">Not Inspected</span>' : number_format($row->weight_fisik);
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
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action', 'tebal_actual', 'weight_actual','tebal_fisik', 'weight_fisik', 'stock_status'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.opname.index');
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
        $data = GoodReceiveItem::with('product', 'goodReceive')->find($id);
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

        $data = GoodReceiveItem::find($id);
        $data->tebal_fisik = $input['tebal_fisik'];
        $data->weight_fisik = $input['weight_fisik'];
        $data->note = $input['note'];
        $data->remark = $input['remark'];
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'success',
        ]);
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

