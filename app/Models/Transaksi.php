<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'id_transaksi';
    protected $table = 'transaksi';

    protected $fillable = ['id_member', 'tgl_order', 'batas_waktu', 'tgl_bayar', 'status', 'dibayar', 'id'];
}
