<?php

    namespace App\Models;

    use GuzzleHttp\Psr7\Request;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class GanamasConcourseDetail extends Model
    {
        use HasFactory;
        protected $table = 'ganamas_concourse_details';

        protected $fillable = [
            '_id',
            'porc_cumplimiento',
            'porc_gestion',
            'cumplimiento',
            'fecha',
            'concourse_id',
            'objetive',
            'puntos',
            'seller_id',
            'ffvv',
            'tipo_llave',
            'porc_faltantes',
            'soles',
            'key_gen',
            'key_plataform',
            'u_negocio',
            'key_home',
            'key_foods',
            'key_personal'
        ];


    }