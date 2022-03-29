<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $primaryKey = 'id_outlet';
    protected $table = 'outlet';
    protected $timestamp = false;

    protected $fillable = ['nama', 'alamat'];
}
