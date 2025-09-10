<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function productTable()
    {
        $userid = Auth::user()->id ?? 1;
        $data = Product::where('userid', $userid);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('product_category', function ($row) {
                if ($row->product_category == 'bahan-baku') {
                    return 'Bahan Baku';
                } else if ($row->product_category == 'bahan-setengah-jadi') {
                    return 'Bahan 1/2 Jadi';
                } else if ($row->product_category == 'barang-jadi') {
                    return 'Barang Jadi';
                }
            })

            ->addColumn('price', function ($row) {
                return number_format($row->price);
            })
            ->addColumn('weight', function ($row) {
                return number_format($row->weight);
            })
            ->addColumn('hpp', function ($row) {
                return number_format($row->hpp);
            })

            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<div style="margin-top:-10px;"><center>';

                $html .= '<a title="Edit Data" href="javascript:void(0);" onclick="editData(' . $row->id . ')" style="margin-right:6px;"><i class="fa fa-edit fa-tombol-edit"></i></a>';
                $html .= '<a title="Delete Data" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')"><i class="fa fa-trash fa-tombol-delete"></i></a>';
                $html .= '</center></div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.product.index');
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
            'product_name' => 'required',
            'product_category' => 'required',
            'satuan' => 'required',
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

            $input['userid'] = Auth::user()->id ?? 1;
            $input['quantity'] = 0;
            $input['hpp'] = 0;
            $input['panjang'] = $request->panjang ?? 0;
            $input['lebar'] = $request->lebar ?? 0;
            $input['tebal'] = $request->tebal ?? 0;
            $input['weight'] = $request->weight ?? 0;
            $input['price'] = $request->price ?? 0;


            Product::create($input);

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
        $data = Product::find($id);
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
            'product_name'     => 'required',
            'product_category' => 'required',
            'satuan'           => 'required',
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $pesan = $validator->errors()->all();
            $html = '';
            foreach ($pesan as $p) {
                $html .= $p . '<br>';
            }

            return response()->json([
                'success' => false,
                'message' => $html,
            ]);
        }

        try {
            $product = Product::find($id);

            $input['userid']  = Auth::user()->id ?? $product->userid;
            $input['panjang'] = $request->panjang ?? $product->panjang ?? 0;
            $input['lebar']   = $request->lebar ?? $product->lebar ?? 0;
            $input['tebal']   = $request->tebal ?? $product->tebal ?? 0;
            $input['weight']  = $request->weight ?? $product->weight ?? 0;
            $input['price']   = $request->price ?? $product->price ?? 0;

            $product->update($input);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
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
        $data = Product::destroy($id);
        return $data;
    }
}
