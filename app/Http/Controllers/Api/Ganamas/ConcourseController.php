<?php

    namespace App\Http\Controllers\Api\Ganamas;

    use App\Models\GanamasConcourse;
    use Carbon\Carbon;

    class ConcourseController extends \App\Http\Controllers\Controller
    {

        public function loadConcourseSaveTable()
        {
            // * ******************************************
            //  * Peticiones Api rest servicios bubble.io
            //  * *******************************************

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://concursoganamas.pe/version-test/api/1.1/obj/Concursos',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS =>'{}',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // * *****************END*************************

            //Convirtiendo a un objeto json parseable
            $ganamasConcourse= json_decode($response, true);

            $datosConcourses = $ganamasConcourse['response']['results'];
            //return $datosConcourses;

            $deleted = GanamasConcourse::query()->delete();
            $Concourses=[];
            foreach($datosConcourses as $concourse) {

                //$ganamasUser = $ganamasUser;
                //return $ganamasUser['authentication']['email']['email'] ;

                if (isset($concourse['Fecha']))
                {
                    $date = Carbon::parse($concourse['Fecha']);
                    $date = $date->format('Y-m-d');
                }else{
                    $date=NULL;
                }


                if (isset($concourse['Categoria']))
                {
                    $category = implode(",",$concourse['Categoria']);
                }else{
                    $category="";
                }
                if (isset($concourse['Tipo de concurso']))
                {
                    $tipo_concurso =implode(",",$concourse['Tipo de concurso']);
                }else{
                    $tipo_concurso ="";
                }

                if (isset($concourse['SKU']))
                {
                    $sku = implode(",",$concourse['SKU']);
                }else{
                    $sku = '';
                }
                if (isset($concourse['UMC']))
                {
                    $umc = $concourse['UMC'];
                }else{
                    $umc="";
                }
                if (isset($concourse['Nombre de Concurso']))
                {
                    $fullname =$concourse['Nombre de Concurso'];
                }else{
                    $fullname='';
                }
                if (isset($concourse['Abreviatura']))
                {
                    $abrevia= $concourse['Abreviatura'];
                }else{
                    $abrevia='';
                }
                if (isset($concourse['Descripcion']))
                {
                    $describe=$concourse['Descripcion'];
                }else{
                    $describe='';
                }
                if (isset($concourse['Codigo concurso']))
                {
                    $codcon=$concourse['Codigo concurso'];
                }else{
                    $codcon='';
                }
                $concourseGanaMas = GanamasConcourse::create([
                    '_id'  => $concourse['_id'] ,
                    'fullname'  => $fullname,
                    'category'   => $category,
                    'type_concourse'  => $tipo_concurso,
                    'abbreviation'    =>  $abrevia,
                    'description'    => $describe,
                    'umc' => $umc,
                    'cod_concourse' => $codcon,
                    'sku' => $sku,
                    'date_concourse' => $date
                ]);
                $Concourses[]=$concourseGanaMas;
            }
            return $Concourses;
        }
    }