<?php

    namespace App\Http\Controllers\Api\Ganamas;

    use App\Models\GanamasConcourseDetail;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class ConcourseDetailController extends \App\Http\Controllers\Controller
    {

        public function loadConcourseDetailSaveTable()
        {
            // * ******************************************
            //  * Peticiones Api rest servicios bubble.io
            //  * *******************************************

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://concursoganamas.pe/version-test/api/1.1/obj/Concursos_por_vendedor',
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
            $ganamasConcourseDetails = json_decode($response, true);

            //return $ganamasConcourseDetails;
            //$datosUsers = $ganamasConcourseDetails['response']['results'][0]['Codigo DEX'];
            $datosConcourseDetails = $ganamasConcourseDetails['response']['results'];
            //return $datosConcourseDetails;

            $ConcourseDetailGanamas=[];

            $deleted = GanamasConcourseDetail::query()->delete();
            foreach($datosConcourseDetails as $concourse) {

                //$ganamasUser = $ganamasUser;
                //return $ganamasUser['authentication']['email']['email'] ;

                if (isset($concourse['Fecha']))
                {
                    $date = Carbon::parse($concourse['Fecha']);
                    $date = $date->format('Y-m-d');
                }else{
                    $date=NULL;
                }
                if (isset($concourse['Llave Foods']))
                {
                    $key_foods= $concourse['Llave Foods'];
                }else{
                    $key_foods=0;
                }
                if (isset($concourse['Llave Plataforma']))
                {
                    $key_plataf=$concourse['Llave Plataforma'];
                }else{
                    $key_plataf=0;
                }
                if (isset($concourse['Llave General']))
                {
                    $key_gen=$concourse['Llave General'];
                }else{
                    $key_gen=0;
                }
                if (isset($concourse['Llave Home Care']))
                {
                    $key_home=$concourse['Llave Home Care'];
                }else{
                    $key_home=0;
                }
                $concourseGanaMas = GanamasConcourseDetail::create([
                    '_id'  => $concourse['_id'] ,
                    'porc_cumplimiento'  => $concourse['% Cumplimiento'],
                    'porc_gestion'   => $concourse['% Gestión'],
                    'cumplimiento'  => $concourse['Cumplimiento'],
                    'fecha'    =>  $date,
                    'concourse_id'    => $concourse['Nombre de concurso'],
                    'objetive' => $concourse['Objetivo'],
                    'puntos' => $concourse['Puntos'],
                    'seller_id' => $concourse['Vendedor'],
                    'ffvv' => $concourse['FFVV'],
                    'tipo_llave' => $concourse['Tipo de llave'],
                    'porc_faltantes' => $concourse['% Faltante'],
                    'soles' => $concourse['Soles'],
                    'key_gen' => $key_gen,
                    'key_plataform' => $key_plataf,
                    'u_negocio' => $concourse['U Negocio'],
                    'key_home' => $key_home,
                    'key_foods' => $key_foods
                ]);
                $ConcourseDetailGanamas[]=$concourseGanaMas;
            }
            return $ConcourseDetailGanamas;
        }


        public function getIndicatorsHome(Request $request)
        {
            $sql="
            SELECT  (
                        select
                             FORMAT(porc_gestion,2)
                         from ganamas_concourse_details
                         where seller_id ='".$request->get('id')."'
                         and month(fecha)=".$request->get('month')."
                         and year(fecha)=".$request->get('year')."
                         and porc_gestion !=0 order by porc_gestion
                         desc limit 1
                     ) as porc_gestion,
                    (
                        select FORMAT(key_gen,2)
                        from ganamas_concourse_details
                        where seller_id ='".$request->get('id')."'
                            and month(fecha)=".$request->get('month')."
                            and year(fecha)=".$request->get('year')."
                            and key_gen !=0
                        order by key_gen desc limit 1
                    )  as key_gen,
                    (
                        select FORMAT(key_home,2)
                        from ganamas_concourse_details
                        where seller_id ='".$request->get('id')."'
                            and month(fecha)=".$request->get('month')."
                            and year(fecha)=".$request->get('year')."
                            and key_home !=0
                        order by key_home desc limit 1
                    ) as key_home,
                    (
                        select FORMAT(key_foods,2)
                        from ganamas_concourse_details
                        where seller_id ='".$request->get('id')."' and
                            month(fecha)=".$request->get('month')." and
                            year(fecha)=".$request->get('year')."
                            and key_foods !=0
                        order by key_foods desc limit 1
                    ) as key_food,
                    (
                        select FORMAT(key_personal,2)
                        from ganamas_concourse_details
                        where seller_id ='".$request->get('id')."'
                            and month(fecha)=".$request->get('month')."
                            and year(fecha)=".$request->get('year')."
                            and key_personal !=0
                        order by key_personal desc limit 1
                    ) as key_personal,
                    (
                        select DATE_FORMAT(created_at, '%d-%m-%Y')
                        from ganamas_concourse_details
                        where seller_id ='".$request->get('id')."'
                            and month(fecha)=".$request->get('month')."
                            and year(fecha)=".$request->get('year')."
                            and key_personal !=0
                        order by key_personal desc limit 1
                    ) as created_at,
                    (
                        select updated_at
                        from ganamas_concourse_details
                        where seller_id ='".$request->get('id')."'
                            and month(fecha)=".$request->get('month')."
                            and year(fecha)=".$request->get('year')."
                            and key_personal !=0
                        order by key_personal desc limit 1
                    ) as updated_at
            ";

            $indicators = DB::select($sql);

            $result = [
                'indicators'=>$indicators,
                'success'=> true
            ];
            return $result;
        }

        public function getEstadoCuenta(Request $request)
        {
            $sql1="
            select sum(soles) as ganados from ganamas_concourse_details where seller_id ='".$request->get('id')."' and month(fecha)=".$request->get('month')." and year(fecha)=".$request->get('year');

            $totalSoles = DB::select($sql1);

            $sql2="
            select cd.concourse_id,s.fullname, sum(cd.soles) as ganados from ganamas_concourse_details cd
 left join ganamas_concourse s on cd.concourse_id = s._id
 where cd.seller_id ='".$request->get('id')."' and month(cd.fecha)=".$request->get('month')." and year(cd.fecha)=".$request->get('year')."
 group by cd.concourse_id,s.fullname order by ganados desc
            ";

            $totalporConcurso = DB::select($sql2);

            $result = [
                'allSoles'=>$totalSoles,
                'allForConcourse'=>$totalporConcurso,
                'success'=> true
            ];
            return $result;
        }

        public function getConcoursesForSeller(Request $request)
        {
            $sql="
            select s._id,s.id, s.fullname,s.sku,s.umc from ganamas_concourse_details cd
left join ganamas_concourse s on cd.concourse_id = s._id
 where cd.seller_id ='".$request->get('id')."' and month(cd.fecha)=".$request->get('month')." and year(cd.fecha)=".$request->get('year')."
 group by cd.concourse_id,s._id,s.id, s.fullname,s.sku,s.umc
            ";

            $concourses = DB::select($sql);



            $result = [
                'concourses'=>$concourses,
                'success'=> true
            ];
            return $result;
        }

        public function getAllConcoursesForSeller(Request $request)
        {
            $sql="
            select s._id,s.id,cd.id as concurse_detail_id, s.fullname,s.sku,s.umc from ganamas_concourse_details cd
left join ganamas_concourse s on cd.concourse_id = s._id
 where cd.seller_id ='".$request->get('id')."' and month(cd.fecha)=".$request->get('month')." and year(cd.fecha)=".$request->get('year')."

            ";

            $concourses = DB::select($sql);



            $result = [
                'concourses'=>$concourses,
                'success'=> true
            ];
            return $result;
        }

        public function getConcourseDetail(Request $request)
        {
            $sql="
            select s._id,s.id,
                s.fullname,s.sku,s.umc,
                s.description,date_format(s.date_concourse_start, '%d/%m/%Y') as date_concourse_start ,
                date_format(s.date_concourse_end, '%d/%m/%Y') as date_concourse_end,
                s.type_concourse ,cd.puntos,cd.soles, cd.avance_cobertura,cd.objetivo_cobertura,cd.avance_cobertura_porc,cd.objetivo_volumen,cd.avance_volumen,cd.avance_volumen_porc
            from ganamas_concourse_details cd
left join ganamas_concourse s on cd.concourse_id = s._id
 where cd.seller_id ='".$request->get('id')."' and month(cd.fecha)=".$request->get('month')." and year(cd.fecha)=".$request->get('year')." and s._id='".$request->get('concourse_id')."'
            ";

            $concourseDetail = DB::select($sql);

            $result = [
                'concourseDetail'=>$concourseDetail,
                'success'=> true
            ];
            return $result;
        }

        public function getAllConcourseDetail(Request $request)
        {
            $sql="
            select s._id,s.id,
                s.fullname,s.sku,s.umc,
                s.description,date_format(s.date_concourse_start, '%d/%m/%Y') as date_concourse_start ,
                date_format(s.date_concourse_end, '%d/%m/%Y') as date_concourse_end,
                s.type_concourse ,cd.puntos,cd.soles, cd.avance_cobertura,cd.objetivo_cobertura,cd.avance_cobertura_porc,cd.objetivo_volumen,cd.avance_volumen,cd.avance_volumen_porc
            from ganamas_concourse_details cd
left join ganamas_concourse s on cd.concourse_id = s._id
 where cd.seller_id ='".$request->get('id')."' and month(cd.fecha)=".$request->get('month')." and year(cd.fecha)=".$request->get('year')." and cd.id='".$request->get('concourse_detail_id')."'
            ";

            $concourseDetail = DB::select($sql);

            $result = [
                'concourseDetail'=>$concourseDetail,
                'success'=> true
            ];
            return $result;
        }
    }

