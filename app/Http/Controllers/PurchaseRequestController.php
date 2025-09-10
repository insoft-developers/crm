<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function purchaseRequestTable(Request $request)
    {
        $userid = Auth::user()->id ?? 1;
        $query = PurchaseRequest::where('userid', $userid);

        // filter tanggal
        if ($request->filter_date) {
            $query->whereDate('request_date', $request->filter_date);
        }

        // filter status
        if ($request->filter_status) {
            $query->where('status', $request->filter_status);
        }
        $data = $query->get();
        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<div class="text-info">Draft</div>';
                } else if ($row->status == 2) {
                    return '<div class="text-warning">Pengajuan</div>';
                } else if ($row->status == 3) {
                    return '<div class="text-success">Disetujui</div>';
                } else if ($row->status == 4) {
                    return '<div class="text-danger"><a onclick="view_rejection_note(' . $row->id . ')" href="javascript:void(0);">Ditolak</a></div>';
                }
            })
            ->addColumn('pr_number', function ($row) {
                return '<a onclick="viewData(' . $row->id . ')" href="javascript:void(0);"><div class="karyawan-id">' . $row->pr_number . '</div></a>';
            })

            ->addColumn('request_user_id', function ($row) {
                return $row->user->name ?? '-';
            })

            ->addColumn('request_date', function ($row) {
                return date('d F Y', strtotime($row->request_date));
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a title="Copy Data" href="javascript:void(0);" onclick="copyData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-copy fa-tombol-copy"></i></a>';
                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Lihat Data" href="javascript:void(0);" onclick="viewData(' . $row->id . ')"><i class="fa fa-eye fa-tombol-view"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action', 'pr_number', 'status'])
            ->make(true);
    }


    public function index()
    {
        return view('frontend.purchase_request.index');
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
            'pr_number' => 'required',
            'request_date' => 'required',
            'product_category' => 'required',
            'description' => 'required',
            'product_id.*' => 'required',
            'quantity.*' => 'required',
            'weight.*' => 'required'
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

            $userid = Auth::user()->id ?? 1;
            $input['userid'] = $userid;
            $input['request_user_id'] = $userid;
            $input['quantity_total'] = 0;
            $input['weight_total'] = 0;
            $input['status'] = 1;
            $purchase_id = PurchaseRequest::create($input)->id;

            $product_ids = $input['product_id'];

            if (count($product_ids) > 0) {

                $total_quantity = 0;
                $total_weight = 0;
                foreach ($product_ids as $index => $pid) {

                    $berat = str_replace(".", "", $input['weight'][$index]);

                    $total_quantity = $total_quantity + $input['quantity'][$index];
                    $total_weight = $total_weight + $berat;
                    PurchaseRequestItem::create([
                        "purchase_id" => $purchase_id,
                        "pr_number" => $input['pr_number'],
                        "product_id" => $pid,
                        "satuan" => $input['satuan'][$index],
                        "panjang" => $input['panjang'][$index],
                        "lebar" => $input['lebar'][$index],
                        "tebal" => $input['tebal'][$index],
                        "quantity" => $input['quantity'][$index],
                        "weight" => $berat,
                        "userid" => $userid,
                    ]);
                }

                PurchaseRequest::where('id', $purchase_id)->update([
                    "quantity_total" => $total_quantity,
                    "weight_total" => $total_weight
                ]);
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
        $data['purchase'] = PurchaseRequest::find($id);
        $data['item'] = PurchaseRequestItem::with('product')->where('purchase_id', $id)->get();
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
        $data['purchase'] = PurchaseRequest::find($id);
        $data['item'] = PurchaseRequestItem::where('purchase_id', $id)->get();

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
            'pr_number' => 'required',
            'request_date' => 'required',
            'product_category' => 'required',
            'description' => 'required',
            'product_id.*' => 'required',
            'quantity.*' => 'required',
            'weight.*' => 'required'
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

            $purchase = PurchaseRequest::find($id);

            $userid = Auth::user()->id ?? 1;
            $input['request_user_id'] = $userid;

            $purchase->update($input);

            $product_ids = $input['product_id'];

            if (count($product_ids) > 0) {

                $total_quantity = 0;
                $total_weight = 0;
                PurchaseRequestItem::where('purchase_id', $id)->delete();
                foreach ($product_ids as $index => $pid) {

                    $berat = str_replace(".", "", $input['weight'][$index]);

                    $total_quantity = $total_quantity + $input['quantity'][$index];
                    $total_weight = $total_weight + $berat;
                    PurchaseRequestItem::create([
                        "purchase_id" => $id,
                        "pr_number" => $input['pr_number'],
                        "product_id" => $pid,
                        "satuan" => $input['satuan'][$index],
                        "panjang" => $input['panjang'][$index],
                        "lebar" => $input['lebar'][$index],
                        "tebal" => $input['tebal'][$index],
                        "quantity" => $input['quantity'][$index],
                        "weight" => $berat,
                        "userid" => $userid,
                    ]);
                }

                PurchaseRequest::where('id', $id)->update([
                    "quantity_total" => $total_quantity,
                    "weight_total" => $total_weight
                ]);
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
    public function generatePrNumber(Request $request)
    {
        $lastPR = PurchaseRequest::latest('id')
            ->first();

        $nextNumber = $lastPR ? $lastPR->id + 1 : 1;

        $prNumber = 'PR-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return response()->json(['pr_number' => $prNumber]);
    }

    public function approve(Request $request)
    {
        $input = $request->all();
        $data = PurchaseRequest::where('id', $input['id'])->update([
            "status" => 3
        ]);

        return $data;
    }


    public function reject(Request $request)
    {
        $input = $request->all();
        $data = PurchaseRequest::where('id', $input['id'])->update([
            "status" => 4,
            "rejection_note_1" => $input['reason']
        ]);

        return $data;
    }
}
