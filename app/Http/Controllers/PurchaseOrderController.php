<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorAlamat;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;


class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use CommonTrait;

    public function purchaseOrderTable(Request $request)
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $query = PurchaseOrder::where('userid', $userid);

        // filter tanggal
        if ($request->filter_date) {
            $query->whereDate('purchase_order_date', $request->filter_date);
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
                    return '<div class="text-info">Diajukan</div>';
                } else if ($row->status == 2) {
                    return '<div class="text-warning">Ditunda</div>';
                } else if ($row->status == 3) {
                    return '<div class="text-success">Disetujui</div>';
                } else if ($row->status == 4) {
                    return '<div class="text-danger"><a onclick="view_rejection_note(' . $row->id . ')" href="javascript:void(0);">Revisi</a></div>';
                }
            })
            ->addColumn('purchase_order_number', function ($row) {
                return '<a onclick="viewData(' . $row->id . ')" href="javascript:void(0);"><div class="karyawan-id">' . $row->purchase_order_number . '</div></a>';
            })

            ->addColumn('vendor_id', function ($row) {
                return $row->vendor->vendor_name ?? '';
            })

            ->addColumn('gudang', function ($row) {
                return $row->alamat->nama ?? '';
            })

            ->addColumn('purchase_order_date', function ($row) {
                return date('d F Y', strtotime($row->purchase_order_date));
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                if ($row->status == 3) {
                    $html .= '<a target="_blank" href="'.url('purchase_order_print/'.$row->id).'" title="Print PO" href="javascript:void(0);" style="margin-right:6px;"><i class="fa fa-print fa-tombol-copy"></i></a>';
                    $html .= '<a class="disabled" title="Edit Data" href="javascript:void(0);" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                } else {
                    $html .= '<a class="disabled" title="Print PO" href="javascript:void(0);" style="margin-right:6px;"><i class="fa fa-print fa-tombol-copy"></i></a>';
                    $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                }

                $html .= '<a title="Lihat Data" href="javascript:void(0);" onclick="viewData(' . $row->id . ')"><i class="fa fa-eye fa-tombol-view"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action', 'purchase_order_number', 'status'])
            ->make(true);
    }


    public function index()
    {
        $userid = $this->set_owner_id(Auth::user()->id);
        $prs = PurchaseRequest::where('userid', $userid)
            ->where('status', 3)
            ->where('is_approve_1', 1)
            ->where('is_approve_2', 1)
            ->whereHas('item', function ($q) {
                // hitung total weight di tabel purchase_request_item
                $q->select(DB::raw('purchase_id, SUM(weight_outstanding) as total_weight'))
                ->groupBy('purchase_id')
                ->havingRaw('SUM(weight_outstanding) > 0');
            })
            ->get();
        $vendors = Vendor::where('userid', $userid)->get();
        $payment_methods = PaymentMethod::select('id', 'code', 'description')->get();
        $delivery_methods = DeliveryMethod::select('id', 'name', 'description')->get();
        return view('frontend.purchase_order.index', compact('prs', 'vendors', 'payment_methods', 'delivery_methods'));
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
            'purchase_request_id' => 'required',
            'vendor_id' => 'required',
            'vendor_address_id' => 'required',
            'purchase_order_number' => 'required',
            'purchase_order_date' => 'required',
            'mill' => 'required',
            'product_category' => 'required',
            'payment_method' => 'required',
            'delivery_method' => 'required',
            'description' => 'required',
            'pr_item_id.*' => 'required',
            'product_id.*' => 'required',
            'quantity.*' => 'required',
            'weight.*' => 'required',
            'price.*' => 'required',
            'price_before_tax.*' => 'required',
            'subtotal' => 'required',
            'total_tax' => 'required',
            'total_price' => 'required'
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
            $userid = Auth::user()->id ?? 1;
            $input['userid'] = $userid;
            $input['request_user_id'] = $userid;
            $input['quantity_total'] = 0;
            $input['weight_total'] = 0;
            $input['status'] = 1;
            $input['subtotal'] = str_replace(".", "", $input['subtotal']);
            $input['total_tax'] = str_replace(".", "", $input['total_tax']);
            $input['total_price'] = str_replace(".", "", $input['total_price']);
            $purchase_id = PurchaseOrder::create($input)->id;

            $product_ids = $input['product_id'];

            if (count($product_ids) > 0) {

                $total_quantity = 0;
                $total_weight = 0;
                foreach ($product_ids as $index => $pid) {

                    $berat = str_replace(".", "", $input['weight'][$index]);
                    $pbt = str_replace(".", "", $input['price_before_tax'][$index]);

                    $total_quantity = $total_quantity + $input['quantity'][$index];
                    $total_weight = $total_weight + $berat;

                    PurchaseOrderItem::create([
                        "purchase_order_id" => $purchase_id,
                        "purchase_order_number" => $input['purchase_order_number'],
                        "product_id" => $pid,
                        "satuan" => $input['satuan'][$index],
                        "panjang" => $input['panjang'][$index],
                        "lebar" => $input['lebar'][$index],
                        "tebal" => $input['tebal'][$index],
                        "quantity" => $input['quantity'][$index],
                        "quantity_outstanding" => $input['quantity'][$index],
                        "quantity_received" => 0,
                        "weight" => $berat,
                        "weight_outstanding" => $berat,
                        "weight_received" => 0,
                        "price" => $input['price'][$index],
                        "tax" => $input['tax'][$index],
                        "price_before_tax" => $pbt,
                        "userid" => $userid,
                        "pr_item_id" => $input['pr_item_id'][$index]
                    ]);


                    PurchaseRequestItem::where('id', $input['pr_item_id'][$index])
                        ->update([
                            'quantity_po' => DB::raw('COALESCE(quantity_po,0) + ' . (int) $input['quantity'][$index]),
                            'quantity_outstanding' => DB::raw('COALESCE(quantity_outstanding,0) - ' . (int) $input['quantity'][$index]),

                            'weight_po' => DB::raw('COALESCE(weight_po,0) + ' . (int) $berat),
                            'weight_outstanding' => DB::raw('COALESCE(weight_outstanding,0) - ' . (int) $berat),
                        ]);
                }

                PurchaseOrder::where('id', $purchase_id)->update([
                    "quantity_total" => $total_quantity,
                    "weight_total" => $total_weight
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
        $data['purchase'] = PurchaseOrder::with('vendor.province','vendor.city','gudang.province','gudang.city','alamat','payment_methods','delivery_methods')->find($id);
        $data['item'] = PurchaseOrderItem::with('product')->where('purchase_order_id', $id)->get();
        $data['request_user_name'] = $data['purchase']->user->name ?? '-';

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
        $data['purchase'] = PurchaseOrder::find($id);
        $data['items'] = PurchaseOrderItem::with('product')->where('purchase_order_id', $id)->get();

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
            'purchase_request_id' => 'required',
            'vendor_id' => 'required',
            'vendor_address_id' => 'required',
            'purchase_order_number' => 'required',
            'purchase_order_date' => 'required',
            'mill' => 'required',
            'product_category' => 'required',
            'payment_method' => 'required',
            'delivery_method' => 'required',
            'description' => 'required',
            'pr_item_id.*' => 'required',
            'product_id.*' => 'required',
            'quantity.*' => 'required',
            'weight.*' => 'required',
            'price.*' => 'required',
            'price_before_tax.*' => 'required',
            'subtotal' => 'required',
            'total_tax' => 'required',
            'total_price' => 'required'
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode('<br>', $validator->errors()->all()),
            ]);
        }

        try {
            DB::beginTransaction();

            $userid = Auth::user()->id ?? 1;

            // format angka
            $input['subtotal'] = str_replace(".", "", $input['subtotal']);
            $input['total_tax'] = str_replace(".", "", $input['total_tax']);
            $input['total_price'] = str_replace(".", "", $input['total_price']);

            $purchase = PurchaseOrder::findOrFail($id);

            /**
             * STEP 1: rollback nilai lama di PurchaseRequestItem
             */
            $oldItems = PurchaseOrderItem::where('purchase_order_id', $purchase->id)->get();

            foreach ($oldItems as $old) {
                PurchaseRequestItem::where('id', $old->pr_item_id)->update([
                    'quantity_po' => DB::raw('COALESCE(quantity_po,0) - ' . (int) $old->quantity),
                    'quantity_outstanding' => DB::raw('COALESCE(quantity_outstanding,0) + ' . (int) $old->quantity),
                    'weight_po' => DB::raw('COALESCE(weight_po,0) - ' . (int) $old->weight),
                    'weight_outstanding' => DB::raw('COALESCE(weight_outstanding,0) + ' . (int) $old->weight),
                ]);
            }

            /**
             * STEP 2: hapus item lama
             */
            PurchaseOrderItem::where('purchase_order_id', $purchase->id)->delete();

            /**
             * STEP 3: update header PurchaseOrder
             */
            $purchase->update([
                'purchase_request_id' => $input['purchase_request_id'],
                'vendor_id' => $input['vendor_id'],
                'vendor_address_id' => $input['vendor_address_id'],
                'purchase_order_number' => $input['purchase_order_number'],
                'purchase_order_date' => $input['purchase_order_date'],
                'mill' => $input['mill'],
                'product_category' => $input['product_category'],
                'payment_method' => $input['payment_method'],
                'delivery_method' => $input['delivery_method'],
                'description' => $input['description'],
                'subtotal' => $input['subtotal'],
                'total_tax' => $input['total_tax'],
                'total_price' => $input['total_price'],
                'userid' => $userid,
                'status' => 1,
            ]);

            /**
             * STEP 4: insert item baru + update PR Item
             */
            $total_quantity = 0;
            $total_weight = 0;

            foreach ($input['product_id'] as $index => $pid) {
                $berat = str_replace(".", "", $input['weight'][$index]);
                $pbt = str_replace(".", "", $input['price_before_tax'][$index]);

                $total_quantity += $input['quantity'][$index];
                $total_weight += $berat;

                PurchaseOrderItem::create([
                    "purchase_order_id" => $purchase->id,
                    "purchase_order_number" => $input['purchase_order_number'],
                    "product_id" => $pid,
                    "satuan" => $input['satuan'][$index],
                    "panjang" => $input['panjang'][$index],
                    "lebar" => $input['lebar'][$index],
                    "tebal" => $input['tebal'][$index],
                    "quantity" => $input['quantity'][$index],
                    "quantity_outstanding" => $input['quantity'][$index],
                    "quantity_received" => 0,
                    "weight" => $berat,
                    "weight_outstanding" => $berat,
                    "weight_received" => 0,
                    "price" => $input['price'][$index],
                    "tax" => $input['tax'][$index],
                    "price_before_tax" => $pbt,
                    "userid" => $userid,
                    "pr_item_id" => $input['pr_item_id'][$index]
                ]);

                PurchaseRequestItem::where('id', $input['pr_item_id'][$index])->update([
                    'quantity_po' => DB::raw('COALESCE(quantity_po,0) + ' . (int) $input['quantity'][$index]),
                    'quantity_outstanding' => DB::raw('COALESCE(quantity_outstanding,0) - ' . (int) $input['quantity'][$index]),
                    'weight_po' => DB::raw('COALESCE(weight_po,0) + ' . (int) $berat),
                    'weight_outstanding' => DB::raw('COALESCE(weight_outstanding,0) - ' . (int) $berat),
                ]);
            }

            // update total header
            $purchase->update([
                "quantity_total" => $total_quantity,
                "weight_total" => $total_weight,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil diupdate',
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

    public function productCategory(Request $request)
    {
        $input = $request->all();

        $userid = Auth::user()->id ?? 1;
        $products = Product::where('product_category', $input['category'])
            ->where('userid', $userid)
            ->get();

        return $products;
    }

    public function selectedProduct(Request $request)
    {
        $input = $request->all();

        $product = Product::find($input['product_id']);
        return $product;
    }

    // di controller
    public function generatePoNumber(Request $request)
    {
        $lastPR = PurchaseOrder::latest('id')
            ->first();

        $nextNumber = $lastPR ? $lastPR->id + 1 : 1;

        $prNumber = 'PO-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return response()->json(['purchase_order_number' => $prNumber]);
    }

    public function approve(Request $request)
    {
        $input = $request->all();
        $data = PurchaseOrder::where('id', $input['id'])->update([
            "status" => 3
        ]);

        return $data;
    }


    public function reject(Request $request)
    {
        $input = $request->all();
        $data = PurchaseOrder::where('id', $input['id'])->update([
            "status" => 4,
            "rejection_note_1" => $input['reason']
        ]);

        return $data;
    }


    public function vendorNote(Request $request)
    {
        $input = $request->all();
        $data = Vendor::with('province', 'city', 'district', 'alamat')->find($input['vendor_id']);
        return $data;
    }

    public function vendorAddress(Request $request)
    {
        $input = $request->all();
        $data = VendorAlamat::with('province', 'city', 'district')->find($input['id']);
        return $data;
    }

    public function purchaseRequestData(Request $request)
    {
        $input = $request->all();

        $data['purchase'] = PurchaseRequest::find($input['id']);
        $data['items'] = PurchaseRequestItem::with('product')
            // ->where('quantity_outstanding', '>', 0)
            ->where('purchase_id', $input['id'])->get();
        return $data;
    }

    public function checkPrQuantity(Request $request)
    {
        $input = $request->all();
        $qty = $input['qty'];
        $mode = $input['mode'];


        $pr_quantity = 0;
        $po_weight = 0;
        $pr_item = PurchaseRequestItem::find($input['pr_item_id']);
        if ($mode == 1) {
            $po_item = PurchaseOrderItem::where('purchase_order_id', $input['po_id'])->where('pr_item_id', $input['pr_item_id'])->first();
            $pr_quantity = $po_item->quantity;
            $po_weight = $po_item->weight;
        } else {

            $pr_quantity = $pr_item->quantity_outstanding;
        }


        $pr_default = $pr_item->quantity;
        $pr_weight_unit = $pr_item->weight / $pr_default;
        $new_weight = $pr_weight_unit * $qty;

        if ($qty >= 0) {
            if ($qty > $pr_quantity) {
                return response()->json([
                    "success" => false,
                    "message" => "Qty Tidak Boleh lebih dari jumlah PR",
                    "data" => $pr_quantity,
                    "weight" => $mode == 1 ? $po_weight : $pr_item->weight_outstanding
                ]);
            } else {
                return response()->json([
                    "success" => true,
                    "message" => "sukses",
                    "weight" => $new_weight
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "message" => "Qty Tidak Boleh Kurang dari Nol",
                "data" => $pr_quantity,
                "weight" => $mode == 1 ? $po_weight : $pr_item->weight_outstanding
            ]);
        }
    }




    public function checkPrWeight(Request $request)
    {
        $input = $request->all();
        $berat = $input['berat'];
        $mode = $input['mode'];


        $po_weight = null;
        $pr_quantity = 0;
        $pr_item = PurchaseRequestItem::find($input['pr_item_id']);
        if ($mode == 1) {
            $po_item = PurchaseOrderItem::where('purchase_order_id', $input['po_id'])->where('pr_item_id', $input['pr_item_id'])->first();
            $po_weight = $pr_item->weight_outstanding;
            $pr_quantity = $po_item->quantity;
        } else {
            $po_weight = $pr_item->weight_outstanding;
            $pr_quantity = $pr_item->quantity_outstanding;
        }

        // dd($po_weight);

        if ($berat >= 0) {
            if ($berat > $po_weight) {
                return response()->json([
                    "success" => false,
                    "message" => "Berat Tidak Boleh lebih dari Berat PR",
                    "data" => $pr_quantity,
                    "weight" => $mode == 1 ? $po_weight : $pr_item->weight_outstanding
                ]);
            } else {
                return response()->json([
                    "success" => true,
                    "message" => "sukses",
                    "weight" => $berat
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "message" => "Bert Tidak Boleh Kurang dari Nol",
                "data" => $pr_quantity,
                "weight" => $mode == 1 ? $po_weight : $pr_item->weight_outstanding
            ]);
        }
    }




    public function print($id) {
        $data['purchase'] = PurchaseOrder::with('vendor.province','vendor.city','gudang.province','gudang.city','alamat','payment_methods','delivery_methods')
        ->where('status', 3)
        ->where('id', $id)->firstOrFail();
        $data['items'] = PurchaseOrderItem::with('product')->where('purchase_order_id', $id)->get();
        $data['request_user_name'] = $data['purchase']->user->name ?? '-';
        $data['title'] = "Purchase Order";
        $userid = Auth::user()->id;
        $data['user'] = User::find($userid);



        $pdf = Pdf::loadView('frontend.purchase_order.print', $data)
                  ->setPaper('a4', 'portrait'); // bisa portrait/landscape

        return $pdf->stream('purchase_order.pdf'); 
    }
}
