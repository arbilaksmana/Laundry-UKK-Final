<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use JWTAuth;

class MemberController extends Controller
{
    // public $user;
    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required|string',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tlp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $member = new Member();
        $member->nama_member = $request->nama_member;
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
        // $data['count'] = Member::count();
        // $data['member'] = Member::get();
        // return response()->json(['data' => $data]);

        $data =Member::get();
        return response()->json($data);
    }

    public function getById($id_member)
    {
        $data= Member::get()->where('id_member', '=', $id_member)->first ();
        return response()->json($data);
    }

    public function update(Request $request, $id_member)
    {
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tlp' => 'required',   
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $member = Member::where('id_member', '=', $id_member)->first();
        $member->nama_member = $request->nama_member;
        $member->alamat = $request->alamat;
        $member->jenis_kelamin = $request->jenis_kelamin;
        $member->tlp = $request->tlp;

        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Data Member Berhasil Diupdate'
        ]);
    }

    public function delete($id_member)
    {
        $delete = Member::where('id_member', '=', $id_member)->delete();

        if ($delete) {
            return response()->json(['message' => 'Berhasil dihapus']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Member Gagal Dihapus'
            ]);
        }
    }
}
