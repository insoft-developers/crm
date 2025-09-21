<?php

namespace App\Http\Controllers;

use App\Models\GoodReceive;
use App\Models\GoodReceiveItem;
use App\Models\Location;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
                    return '<div class="text-info">Dikirim</div>';
                } elseif ($row->status == 2) {
                    return '<div class="text-kuning">Outstanding</div>';
                } elseif ($row->status == 3) {
                    return '<div class="text-success">Proses</div>';
                } elseif ($row->status == 4) {
                    return '<div class="text-success">Selesai</div>';
                }
            })
            ->addColumn('gr_number', function ($row) {
                return '<a onclick="viewData(' . $row->id . ')" href="javascript:void(0);"><div class="karyawan-id">' . $row->gr_number . '</div></a>';
            })

            ->addColumn('vendor_id', function ($row) {
                return $row->vendor->vendor_name ?? '';
            })
            ->addColumn('warehouse_id', function ($row) {
                return $row->warehouse->name ?? '';
            })
            ->addColumn('gr_date', function ($row) {
                return date('d F Y', strtotime($row->gr_date));
            })
            ->addColumn('total_weight_received', function ($row) {
                return number_format($row->total_weight_received);
            })
            ->addColumn('good_status', function ($row) {
                return $row->good_status == 1 ? 'Stok' : 'Titipan';
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a target="_blank" href="' . url('purchase_order_print/' . $row->id) . '" title="Print PO" href="javascript:void(0);" style="margin-right:6px;"><i class="fa fa-print fa-tombol-copy"></i></a>';

                if ($row->status == 4) {
                    $html .= '<a class="disabled" title="Edit Data" href="javascript:void(0);" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                } else {
                    $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                }

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
        $locations = Location::where('userid', $this->set_owner_id(Auth::user()->id))->get();

        return view('frontend.good_receive.index', compact('locations'));
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
            'gr_number' => 'required',
            'gr_date' => 'required',
            'po_id' => 'required',
            'contract_number' => 'required',
            'good_id_item.*' => 'required',
            'sp_number.*' => 'required',
            'delivery_date.*' => 'required',
            'arrive_date.*' => 'required',
            'coil_number.*' => 'required',
            'quantity_received.*' => 'required',
            'weight_received.*' => 'required',
            'total_weight' => 'required',
            'total_weight_received' => 'required',
            'total_weight_outstanding' => 'required',
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
            DB::beginTransaction();

            $userid = $this->set_owner_id(Auth::user()->id);
            $order = PurchaseOrder::with('payment_methods')->find($input['po_id']);
            $item_count = PurchaseOrderItem::where('purchase_order_id', $input['po_id'])->sum('weight_outstanding');

            $jatuh_tempo = $this->hitung_jatuh_tempo($order->purchase_order_date, $order->payment_methods->term_days);

            $wo = str_replace('.', '', $input['total_weight_outstanding']);

            $input['po_number'] = $order->purchase_order_number;
            $input['vendor_id'] = $order->vendor_id;
            $input['warehouse_id'] = $order->vendor_address_id;
            $input['mills'] = $order->mill;
            $input['product_category'] = $order->product_category;
            $input['total_quantity'] = 0;
            $input['total_weight'] = str_replace('.', '', $input['total_weight']);
            $input['total_weight_received'] = str_replace('.', '', $input['total_weight_received']);
            $input['total_weight_outstanding'] = $wo;
            $input['good_status'] = 1;
            $input['due_date'] = $jatuh_tempo;
            $input['payment_method_id'] = $order->payment_method;
            $input['delivery_method_id'] = $order->delivery_method;
            $input['description'] = $order->description;
            $input['request_user_id'] = Auth::user()->id;
            $input['userid'] = $userid;

            $id = GoodReceive::create($input)->id;
            $items = $input['product_id'];

            if (count($items) > 0) {
                $received = 0;
                foreach ($items as $index => $item) {
                    $int_berat = str_replace('.', '', $input['weight'][$index]);
                    $received = $received + $input['weight_received'][$index];
                    $gr = GoodReceiveItem::create([
                        'gr_id' => $id,
                        'po_item_id' => $input['good_id_item'][$index],
                        'sp_number' => $input['sp_number'][$index],
                        'delivery_date' => $input['delivery_date'][$index],
                        'arrive_date' => $input['arrive_date'][$index],
                        'coil_number' => $input['coil_number'][$index],
                        'product_id' => $input['product_id'][$index],
                        'tebal' => $input['tebal'][$index],
                        'lebar' => $input['lebar'][$index],
                        'panjang' => $input['panjang'][$index],
                        'quantity' => $input['quantity'][$index],
                        'quantity_received' => $input['quantity_received'][$index],
                        'quantity_outstanding' => $input['quantity'][$index] - $input['quantity_received'][$index],
                        'weight' => $int_berat,
                        'weight_received' => $input['weight_received'][$index],
                        'weight_outstanding' => $int_berat - $input['weight_received'][$index],
                        'satuan' => $input['satuan'][$index],
                        'location' => $input['location'][$index],
                        'userid' => $userid,
                    ]);

                    if ($gr) {
                        $curr_po = PurchaseOrderItem::find($input['good_id_item'][$index]);
                        PurchaseOrderItem::where('id', $input['good_id_item'][$index])->update([
                            'quantity_received' => $curr_po->quantity_received + $input['quantity_received'][$index],
                            'quantity_outstanding' => $curr_po->quantity_outstanding - $input['quantity_received'][$index],
                            'weight_received' => $curr_po->weight_received + $input['weight_received'][$index],
                            'weight_outstanding' => $curr_po->weight_outstanding - $input['weight_received'][$index],
                        ]);

                        $pro_list = Product::find($item);
                        Product::where('id', $item)->update([
                            'quantity' => $pro_list->quantity + $input['quantity_received'][$index],
                            'weight' => $pro_list->weight + $input['weight_received'][$index],
                        ]);
                    }
                }
            }

            if ($item_count == $received) {
                GoodReceive::where('po_id', $input['po_id'])->update([
                    'status' => 4,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                GoodReceive::where('po_id', $input['po_id'])->update([
                    'status' => 2,
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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
        $data = GoodReceive::with('item')->find($id);
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
            'gr_number' => 'required',
            'gr_date' => 'required',
            'po_id' => 'required',
            'contract_number' => 'required',
            'good_id_item.*' => 'required',
            'sp_number.*' => 'required',
            'delivery_date.*' => 'required',
            'arrive_date.*' => 'required',
            'coil_number.*' => 'required',
            'quantity_received.*' => 'required',
            'weight_received.*' => 'required',
            'total_weight' => 'required',
            'total_weight_received' => 'required',
            'total_weight_outstanding' => 'required',
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
            DB::beginTransaction();

            $query = GoodReceive::find($id);

            $userid = $this->set_owner_id(Auth::user()->id);
            $order = PurchaseOrder::with('payment_methods')->find($input['po_id']);
            $item_count = PurchaseOrderItem::where('purchase_order_id', $input['po_id'])->sum('weight_outstanding');

            $input['total_quantity'] = 0;
            $input['total_weight'] = str_replace('.', '', $input['total_weight']);
            $input['total_weight_received'] = str_replace('.', '', $input['total_weight_received']);
            $input['total_weight_outstanding'] = str_replace('.', '', $input['total_weight_outstanding']);
            $input['good_status'] = 1;
            $input['request_user_id'] = Auth::user()->id;
            $input['userid'] = $userid;

            $query->update($input);

            $old_items = GoodReceiveItem::where('gr_id', $id)->get();
            
            foreach ($old_items as $old) {
                $curr_po = PurchaseOrderItem::find($old->po_item_id);
                PurchaseOrderItem::where('id', $old->po_item_id)->update([
                    'quantity_received' => $curr_po->quantity_received - $old->quantity_received,
                    'quantity_outstanding' => $curr_po->quantity_outstanding + $old->quantity_received,
                    'weight_received' => $curr_po->weight_received - $old->weight_received,
                    'weight_outstanding' => $curr_po->weight_outstanding + $old->weight_received,
                ]);

                $pro_list = Product::find($old->product_id);
                Product::where('id', $old->product_id)->update([
                    'quantity' => $pro_list->quantity - $old->quantity_received,
                    'weight' => $pro_list->weight - $old->weight_received,
                ]);

                $old->delete();
            }

            $items = $input['product_id'];

            if (count($items) > 0) {
                $received = 0;
                foreach ($items as $index => $item) {
                    $int_berat = str_replace('.', '', $input['weight'][$index]);
                    $received = $received + $input['weight_received'][$index];
                    $gr = GoodReceiveItem::create([
                        'gr_id' => $id,
                        'po_item_id' => $input['good_id_item'][$index],
                        'sp_number' => $input['sp_number'][$index],
                        'delivery_date' => $input['delivery_date'][$index],
                        'arrive_date' => $input['arrive_date'][$index],
                        'coil_number' => $input['coil_number'][$index],
                        'product_id' => $input['product_id'][$index],
                        'tebal' => $input['tebal'][$index],
                        'lebar' => $input['lebar'][$index],
                        'panjang' => $input['panjang'][$index],
                        'quantity' => $input['quantity'][$index],
                        'quantity_received' => $input['quantity_received'][$index],
                        'quantity_outstanding' => $input['quantity'][$index] - $input['quantity_received'][$index],
                        'weight' => $int_berat,
                        'weight_received' => $input['weight_received'][$index],
                        'weight_outstanding' => $int_berat - $input['weight_received'][$index],
                        'satuan' => $input['satuan'][$index],
                        'location' => $input['location'][$index],
                        'userid' => $userid,
                    ]);

                    if ($gr) {
                        $curr_po = PurchaseOrderItem::find($input['good_id_item'][$index]);
                        PurchaseOrderItem::where('id', $input['good_id_item'][$index])->update([
                            'quantity_received' => $curr_po->quantity_received + $input['quantity_received'][$index],
                            'quantity_outstanding' => $curr_po->quantity_outstanding - $input['quantity_received'][$index],
                            'weight_received' => $curr_po->weight_received + $input['weight_received'][$index],
                            'weight_outstanding' => $curr_po->weight_outstanding - $input['weight_received'][$index],
                        ]);

                        $pro_list = Product::find($item);
                        Product::where('id', $item)->update([
                            'quantity' => $pro_list->quantity + $input['quantity_received'][$index],
                            'weight' => $pro_list->weight + $input['weight_received'][$index],
                        ]);
                    }
                }
            }

            if ($item_count == $received) {
                GoodReceive::where('po_id', $input['po_id'])->update([
                    'status' => 4,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                GoodReceive::where('po_id', $input['po_id'])->update([
                    'status' => 2,
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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

    public function poDataServe(Request $request)
    {
        $input = $request->all();

        if ($input['save_index'] == 'add') {
            $data['po'] = PurchaseOrder::with('item.product', 'vendor.province', 'vendor.city', 'gudang.rprovince', 'gudang.rcity', 'payment_methods', 'delivery_methods')->find($input['id']);
        } else {
            $data['po'] = GoodReceive::with('item.product', 'vendor.province', 'vendor.city', 'warehouse.rprovince', 'warehouse.rcity', 'payment_methods', 'delivery_methods')->find($input['gr_id']);
        }

        return $data;
    }

    public function weightReceiveChange(Request $request)
    {
        $input = $request->all();
        $save_index = $input['save_index'];
        $po_item = null;
        $berat = $input['berat'] ?? 0;

        if ($save_index == 'edit') {
            $po_item = GoodReceiveItem::find($input['item_id']);
            if ($berat > $po_item->weight_received) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berat tidak boleh lebih dari berat PO',
                    'data' => $po_item->weight_received,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                ]);
            }
        } else {
            $po_item = PurchaseOrderItem::find($input['item_id']);
            if ($berat > $po_item->weight_outstanding) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berat tidak boleh lebih dari berat PO',
                    'data' => $po_item->weight_outstanding,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                ]);
            }
        }

        // if ($berat == 0) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Berat tidak boleh 0',
        //         'data' => $po_item->weight_outstanding,
        //     ]);
        // }
    }
}
