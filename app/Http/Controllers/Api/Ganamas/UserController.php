<?php

namespace App\Http\Controllers\Api\Ganamas;

use App\Http\Controllers\Controller;
use App\Models\GanamasDex;
use App\Models\GanamasUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUserForCode(Request $request) {

        $sql = "
            SELECT
    DATE_FORMAT(CURDATE(), '%m') as month_number,
    DATE_FORMAT(CURDATE(), '%Y') as year_number,
    CASE
    WHEN DATE_FORMAT(CURDATE(), '%m') = '01' THEN 'ENERO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '02' THEN 'FEBRERO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '01' THEN 'MARZO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '04' THEN 'ABRIL'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '05' THEN 'MAYO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '06' THEN 'JUNIO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '07' THEN 'JULIO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '08' THEN 'AGOSTO'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '09' THEN 'SEPTIEMBRE'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '10' THEN 'OCTUBRE'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '11' THEN 'NOVIEMBRE'
    WHEN DATE_FORMAT(CURDATE(), '%m') = '12' THEN 'DICIEMBRE'
  END as month
UNION
SELECT
    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') as month_number,
    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y') as year_number,
    CASE
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '01' THEN 'ENERO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '02' THEN 'FEBRERO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '01' THEN 'MARZO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '04' THEN 'ABRIL'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '05' THEN 'MAYO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '06' THEN 'JUNIO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '07' THEN 'JULIO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '08' THEN 'AGOSTO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '09' THEN 'SEPTIEMBRE'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '10' THEN 'OCTUBRE'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '11' THEN 'NOVIEMBRE'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%m') = '12' THEN 'DICIEMBRE'
  END as month
UNION
SELECT
    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') as month_number,
    DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%Y') as year_number,
    CASE
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '01' THEN 'ENERO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '02' THEN 'FEBRERO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '03' THEN 'MARZO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '04' THEN 'ABRIL'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '05' THEN 'MAYO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '06' THEN 'JUNIO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '07' THEN 'JULIO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '08' THEN 'AGOSTO'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '09' THEN 'SEPTIEMBRE'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '10' THEN 'OCTUBRE'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '11' THEN 'NOVIEMBRE'
    WHEN DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH), '%m') = '12' THEN 'DICIEMBRE'
 END as month
            ";
        //Verificando si exite el código del user
        if(GanamasUser::where('cod_territorio',$request->get('code'))->exists()){
            $user = DB::table('ganamas_user as u')
                ->select('u._id as id','u.cod_territorio as code','u.fullname as name','u.ffvv',
                    'd.fullname as dex','d._id as dex_id')
                ->leftJoin('ganamas_dex as d', 'd._id', '=', 'u.codigo_dex')
                ->where('u.cod_territorio',$request->get('code'))
                ->first();


            $months = DB::select($sql);

            $result = [
                'user'=>$user,
                'months'=>$months,
                'success'=> true
            ];
        }else{
            $months = DB::select($sql);
            $result = [
                'user'=>null,
                'months'=>$months,
                'success'=> false
            ];
        }
       // return $request;
        /*
        if ($request->get('code') == '485706'){
            $user=[
                'id' => 1,
                'code' => '485706',
                'name' => 'CHARLES CCALLOCUNTO CONDE'

            ];

            $result = [
                'user'=>$user,
                'success'=> true
            ];
        } else{
            $result = [
                'user'=>null,
                'success'=> false
            ];
        }
        */
        return $result;

    }

    public function loadUserSaveTable()
    {

        // * ******************************************
        //  * Peticiones Api rest servicios bubble.io
        //  * *******************************************

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://concursoganamas.pe/version-test/api/1.1/obj/User',
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
        $ganamasUsers = json_decode($response, true);

        //return $ganamasUsers;
        //$datosUsers = $ganamasUsers['response']['results'][0]['Codigo DEX'];
        $datosUsers = $ganamasUsers['response']['results'];
        //return $datosUsers;

        $deleted = GanamasUser::query()->delete();

        $UserGanamas=[];
        foreach($datosUsers as $ganamasUser) {

            //$ganamasUser = $ganamasUser;
            //return $ganamasUser['authentication']['email']['email'] ;


            $ffvv = implode(",",$ganamasUser['FFVV']);
            $cod_territorio =implode(",",$ganamasUser['Cod Territorio']);
            $codigo_dex = implode(",",$ganamasUser['Codigo DEX']);
            $userGanaMas = GanamasUser::create([
                '_id'  => $ganamasUser['_id'] ,
                'fullname'  => $ganamasUser['Nombre'] ,
                'email'   => $ganamasUser['authentication']['email']['email'] ,
                'dni'  => $ganamasUser['DNI'] ,
                'ffvv'    =>  $ffvv,
                'cod_territorio'    => $cod_territorio,
                'codigo_dex' => $codigo_dex
            ]);
            $UserGanamas[]=$userGanaMas;
        }

        return $UserGanamas;
    }

    public function loadDexSaveTable()
    {
        // * ******************************************
        //  * Peticiones Api rest servicios bubble.io
        //  * *******************************************

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://concursoganamas.pe/version-test/api/1.1/obj/DEX',
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
        $ganamasDex = json_decode($response, true);

        //return $ganamasUsers;
        //$datosUsers = $ganamasUsers['response']['results'][0]['Codigo DEX'];
        $datosDex = $ganamasDex['response']['results'];
        //return $datosDex;

        $deleted = GanamasDex::query()->delete();

        $DexGanamas=[];
        foreach($datosDex as $ganamasDex) {
            $dex = GanamasDex::create([
                '_id'  => $ganamasDex['_id'] ,
                'fullname'  => $ganamasDex['Nombre DEX'] ,
                'code'   => $ganamasDex['Codigo DEX']
            ]);
            $DexGanamas[]=$dex;
        }

        return $DexGanamas;
    }
}
