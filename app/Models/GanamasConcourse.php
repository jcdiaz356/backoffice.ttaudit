<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GanamasConcourse extends Model
{
    use HasFactory;
    protected $table = 'ganamas_concourse';

    protected $fillable = [
        '_id',
        'category',
        'fullname',
        'type_concourse',
        'abbreviation',
        'description',
        'umc',
        'cod_concourse',
        'sku',
        'date_concourse'
    ];

}
