<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'id_member';
    protected $table = 'member';

    protected $fillable = ['nama_member', 'alamat', 'jenis_kelamin', 'tlp'];
}
