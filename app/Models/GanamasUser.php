<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GanamasUser extends Model
{
    use HasFactory;
    protected $table = 'ganamas_user';

    protected $fillable = [
        '_id',
        'fullname',
        'email',
        'dni',
        'ffvv',
        'dex_id',
        'codigo_dex',
        'cod_territorio',
        'active'
    ];

}
