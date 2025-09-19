<?php

namespace App\Http\Controllers;

use App\Models\GoodReceive;
use App\Models\PurchaseOrder;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GoodReceiveController extends Controller
{
    use CommonTrait;

    public function goodReceiveTable(Request $request)
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $query = GoodReceive::where('userid', $userid);

        // filter tanggal
        if ($request->filter_date) {
            $query->whereDate('gr_date', $request->filter_date);
        }

        // filter status
        if ($request->filter_status) {
            $query->where('status', $request->filter_status);
        }

        if ($request->filter_vendor) {
            $query->where('vendor_id', $request->filter_vendor);
        }

        $data = $query->get();
        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<div class="text-info">Draft</div>';
                } elseif ($row->status == 2) {
                    return '<div class="text-kuning">Pengajuan</div>';
                } elseif ($row->status == 3) {
                    if ($row->is_approve_2 === 1) {
                        return '<div class="text-success">Disetujui <i class="fa fa-check-circle"></i><i class="fa fa-check-circle"></i></div>';
                    } else {
                        return '<div class="text-success">Disetujui <i class="fa fa-check-circle"></i></div>';
                    }
                } elseif ($row->status == 4) {
                    return '<div class="text-danger"><a onclick="view_rejection_note(' . $row->id . ')" href="javascript:void(0);">Ditolak</a></div>';
                }
            })
            ->addColumn('gr_number', function ($row) {
                return '<a onclick="viewData(' . $row->id . ')" href="javascript:void(0);"><div class="karyawan-id">' . $row->gr_number . '</div></a>';
            })

            ->addColumn('vendor_id', function ($row) {
                return $row->vendor->vendor_name ?? '';
            })
            ->addColumn('gr_date', function ($row) {
                return date('d F Y', strtotime($row->gr_date));
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a target="_blank" href="' . url('purchase_order_print/' . $row->id) . '" title="Print PO" href="javascript:void(0);" style="margin-right:6px;"><i class="fa fa-print fa-tombol-copy"></i></a>';
                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';

                $html .= '<a title="Lihat Data" href="javascript:void(0);" onclick="viewData(' . $row->id . ')"><i class="fa fa-eye fa-tombol-view"></i></a>';

                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action', 'gr_number', 'status'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.good_receive.index');
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
        //
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
        //
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


    public function getPoData(Request $request)
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $data = PurchaseOrder::where('userid', $userid)
            ->where('status', 3)
            ->where('is_approve_1', 1)
            ->where('is_approve_2', 1)
            ->whereHas('item', function ($q) {
                // hitung total weight di tabel purchase_request_item
                $q->select(DB::raw('purchase_order_id, SUM(weight_outstanding) as total_weight'))->groupBy('purchase_order_id')->havingRaw('SUM(weight_outstanding) > 0');
            })
            ->get();

        return $data;
    }


    public function generateGrNumber(Request $request)
    {
        $lastPR = GoodReceive::latest('id')->first();

        $nextNumber = $lastPR ? $lastPR->id + 1 : 1;

        $prNumber = 'GR-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return response()->json(['gr_number' => $prNumber]);
    }

    public function poDataServe(Request $request) {
        $input = $request->all();

        $data['po'] = PurchaseOrder::with('item','vendor.province','vendor.city','gudang.rprovince','gudang.rcity')->find($input['id']);
        return $data;
    }
}
