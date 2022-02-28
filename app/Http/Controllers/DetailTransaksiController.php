<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class DetailTransaksiController extends Controller
{
    // public $user;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_transaksi' => 'required',
            'id_paket' => 'required',
            'quantity' => 'required',
            'subtotal' => 'required',
        ]);

        if ($validator->fails()) {
            // return $this->response->errorResponse($validator->fails());
            return response()->json($validator->errors());
        }

        $detail = new DetailTransaksi();
        $detail->id_transaksi = $request->id_transaksi;
        $detail->id_paket = $request->id_paket;
        $detail->subtotal = $request->subtotal;

        //GET HARGA PAKET
        $paket = Paket::where('id_paket', '=', $detail->id_paket)->first();
        $harga = $paket->harga;

        $detail->quantity = $request->quantity;
        $detail->subtotal = $detail->quantity * $harga;

        $detail->save();

        $data = DetailTransaksi::where('id_detail_transaksi', '=', $detail->id_detail_transaksi)->first();

        return response()->json(['message' => 'Berhasil tambah detil transaksi', 'data' => $data]);

        // return $this->response->successResponseData('Berhasil tambah detil transaksi', $data);
    }

    public function getById($id)
    {
        //untuk ambil detil dari transaksi tertentu

        $data = DB::table('detail_transaksi')->join('paket', 'detail_transaksi.id_paket', 'paket.id_paket')
            ->select('detail_transaksi.*', 'paket.jenis')
            ->where('detail_transaksi.id_transaksi', '=', $id)
            ->get();
        return response()->json($data);
    }

    public function getTotal($id)
    {
        $total = DetailTransaksi::where('id_transaksi', $id)->sum('subtotal');

        return response()->json([
            'total' => $total
        ]);
    }
}
