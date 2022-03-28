<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tlp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $member = new Member();
        $member->nama = $request->nama;
        $member->alamat = $request->alamat;
        $member->jenis_kelamin = $request->jenis_kelamin;
        $member->tlp = $request->tlp;

        $member->save();

        $data = Member::where('id_member', '=', $member->id_member)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data Member Berhasil Di Tambahkan',
            'data' => $data,
        ]);
    }

    public function getAll()
    {
        $data = Member::get();
        return response()->json($data);

        // $data = Member::paginate(10);
        // return response()->json($data);
    }

    public function cari_data($key)
    {
        $data = Member::where('nama', 'like', '%' . $key . '%')->get();
        $data = Member::where('alamat', 'like', '%' . $key . '%')->get();
        return response()->json($data);
    }

    public function count()
    {
        $data['count'] = Member::count();
        return response()->json(['data' => $data]);
    }

    public function getById($id)
    {
        $data = Member::where('id_member', $id)->first();
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tlp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $member = Member::where('id_member', '=', $id)->first();
        $member->nama = $request->nama;
        $member->alamat = $request->alamat;
        $member->jenis_kelamin = $request->jenis_kelamin;
        $member->tlp = $request->tlp;

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Member Berhasil Diupdate'
        ]);
    }

    public function delete($id)
    {
        $delete = Member::where('id_member', '=', $id)->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data Member Berhasil Dihapus'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Member Gagal Dihapus'
            ]);
        }
    }
}
