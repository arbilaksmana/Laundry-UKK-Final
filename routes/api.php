<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\OutletController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['jwt.verify:admin,kasir,owner']], function () {
    Route::get('login/check', [UserController::class, 'loginCheck']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('getuser', [UserController::class, 'getUser']);
    Route::get('dashboard', [DashboardController::class, 'index']);
});

//Route khusus admin
Route::group(['middleware' => ['jwt.verify:admin']], function () {

    //OUTLET
    Route::post('insert_outlet', [OutletController::class, 'store']);
    Route::get('get_outlet', [OutletController::class, 'getAll']);
    Route::get('get_outlet_id/{id}', [OutletController::class, 'getById']);
    Route::put('update_outlet/{id}', [OutletController::class, 'update']);
    Route::delete('delete_paketoutlet/{id}', [OutletController::class, 'delete']);

    //PAKET
    Route::post('insert_paket', [PaketController::class, 'store']);
    Route::get('get_paket', [PaketController::class, 'getAll']);
    Route::get('get_paket_id/{id}', [PaketController::class, 'getById']);
    Route::put('update_paket/{id}', [PaketController::class, 'update']);
    Route::delete('delete_paket/{id}', [PaketController::class, 'delete']);

    //USER
    Route::post('insert_user', [UserController::class, 'store']);
    Route::get('get_user', [UserController::class, 'getAll']);
    Route::get('get_user_id/{id}', [UserController::class, 'getById']);
    Route::put('update_user/{id}', [UserController::class, 'update']);
    Route::delete('delete_user/{id}', [UserController::class, 'delete']);
});

//Route khusus admin & kasir
Route::group(['middleware' => ['jwt.verify:admin,kasir']], function () {

    //MEMBER
    Route::post('insert_member', [MemberController::class, 'store']);
    Route::get('get_member', [MemberController::class, 'getAll']);
    Route::get('get_member_id/{id}', [MemberController::class, 'getById']);
    Route::put('update_member/{id}', [MemberController::class, 'update']);
    Route::delete('delete_member/{id}', [MemberController::class, 'delete']);
    Route::get('count_member', [MemberController::class, 'count']);

    //TRANSAKSI
    Route::post('insert_transaksi', [TransaksiController::class, 'store']);
    Route::get('transaksi/{id}', [TransaksiController::class, 'getById']);
    Route::get('get_transaksi', [TransaksiController::class, 'getAll']);
    Route::put('update_transaksi/{id}', [TransaksiController::class, 'update']);

    //DETAIL TRANSAKSI
    Route::post('transaksi/detail/tambah', [DetailTransaksiController::class, 'store']);
    Route::get('transaksi/detail/{id}', [DetailTransaksiController::class, 'getById']);
    Route::post('transaksi/status/{id}', [TransaksiController::class, 'changeStatus']);
    Route::post('transaksi/bayar/{id}', [TransaksiController::class, 'bayar']);
    Route::get('transaksi/total/{id}', [DetailTransaksiController::class, 'getTotal']);
});

//Route Khusus Owner
Route::group(['middleware' => ['jwt.verify:owner, admin, kasir']], function () {
    
});
Route::post('report', [TransaksiController::class, 'report']);