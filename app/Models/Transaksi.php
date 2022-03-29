<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'id_transaksi';
    protected $table = 'transaksi';

<<<<<<< HEAD
    protected $fillable = ['id_member', 'tgl_order', 'batas_waktu', 'tgl_bayar', 'status', 'dibayar', 'id'];
=======
    protected $fillable = ['id_member', 'tgl_order', 'batas_waktu', 'tgl_bayar', 'status', 'dibayar', 'subtotal', 'id', 'id_outlet'];

>>>>>>> 86174792523889bc51d0dd98860dc0eb34db59a0
}
