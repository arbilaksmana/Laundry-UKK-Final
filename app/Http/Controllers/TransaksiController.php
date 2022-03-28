<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransaksiController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaksi = new Transaksi();
        $transaksi->id_member = $request->id_member;
        $transaksi->tgl_order = Carbon::now();
        $transaksi->batas_waktu = Carbon::now()->addDays(3);
        $transaksi->status = 'baru';
        $transaksi->dibayar = 'belum dibayar';
        $transaksi->subtotal = NULL;
        $transaksi->id = $this->user->id;

        $transaksi->save();

        $data = Transaksi::where('id_transaksi', '=', $transaksi->id_transaksi)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data Transaksi Berhasil Ditambahkan',
            'data' => $data
        ]);
    }

    public function getAll()
    {
        $id_user = $this->user->id;
        $data_user = User::where('id', '=', $id_user)->first();

        $data = DB::table('transaksi')
            ->join('member', 'transaksi.id_member', '=', 'member.id_member')
            ->join('users', 'transaksi.id', 'users.id')
            ->select('transaksi.*', 'member.nama', 'users.name')
            ->where('users.id_outlet', $data_user->id_outlet)
            ->orderBy('transaksi.tgl_order', 'DESC')
            ->get();

        return response()->json(['success' => true, 'data' => $data]);


        // $data = DB::table('transaksi')->join('member', 'transaksi.id_member', '=', 'member.id_member')
        //     ->select('transaksi.*', 'member.nama')
        //     ->orderBy('transaksi.tgl_order', 'DESC')
        //     ->get();

        // return response()->json($data);
    }

    public function cari_data($key)
    {
        $data = DB::table('transaksi')->join('member', 'transaksi.id_transaksi', '=', 'member.id_member')
            ->select('transaksi.*', 'member.nama')
            ->where('nama', 'like', '%' . $key . '%')
            ->get();
        return response()->json($data);
    }

    public function getById($id)
    {
        $data = Transaksi::where('id_transaksi', '=', $id)->first();
        $data = DB::table('transaksi')->join('member', 'transaksi.id_member', '=', 'member.id_member')
            ->select('transaksi.*', 'member.nama')
            ->where('transaksi.id_transaksi', '=', $id)
            ->first();
        return response()->json($data);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaksi = Transaksi::find($id);

        $transaksi->update($request->all());

        return response()->json(['message' => 'Transaksi berhasil diubah']);
    }


    public function changeStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaksi = Transaksi::where('id_transaksi', '=', $id)->first();
        $transaksi->status = $request->status;

        $transaksi->save();

        return response()->json(['message' => 'Status berhasil diubah']);
    }

    public function bayar($id)
    {
        $transaksi = Transaksi::where('id_transaksi', '=', $id)->first();
        $subtotal = DetailTransaksi::where('id_detail_transaksi', $id)->sum('subtotal');

        $transaksi->tgl_bayar = Carbon::now();
        $transaksi->status = "Diambil";
        $transaksi->dibayar = "Dibayar";
        $transaksi->subtotal = $subtotal;

        $transaksi->save();

        return response()->json(['message' => 'Pembayaran berhasil']);
    }

    public function report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required',
            'bulan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $id_user = $this->user->id;
        $data_user = User::where('id', '=', $id_user)->first();

        $data = DB::table('transaksi')->join('member', 'transaksi.id_member', '=', 'member.id_member')
            ->join('users', 'transaksi.id', '=', 'users.id')
            ->select('transaksi.id', 'member.nama', 'transaksi.tgl_order', 'transaksi.tgl_bayar', 'transaksi.subtotal', 'users.name')
            ->where('users.id_outlet', $data_user->id_outlet)
            ->whereYear('transaksi.tgl_order', '=', $tahun)
            ->whereMonth('transaksi.tgl_order', '=', $bulan)
            ->get();

        return response()->json($data);

        // $validator = Validator::make($request->all(), [
        //     'tahun' => 'required',
        //     'bulan' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors());
        // }

        // $tahun = $request->tahun;
        // $bulan = $request->bulan;

        // $data = DB::table('transaksi')
        //     ->join('member', 'transaksi.id_member', '=', 'member.id_member')
        //     ->select('transaksi.id', 'transaksi.tgl_order', 'transaksi.tgl_bayar', 'transaksi.subtotal', 'member.nama')
        //     ->whereYear('tgl_order', '=', $tahun)
        //     ->whereMonth('tgl_order', '=', $bulan)
        //     ->orderBy('transaksi.tgl_order', 'ASC')
        //     ->get();

        // return response()->json($data);
    }
    public function jumlahPendapatan(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $pendapatan = DB::table('transaksi')->join('member', 'transaksi.id_member', '=', 'member.id_member')
            ->select('transaksi.subtotal')
            ->whereYear('tgl_order', '=', $tahun)
            ->whereMonth('tgl_order', '=', $bulan)
            ->sum('subtotal');

        return response()->json($pendapatan);
    }
}
