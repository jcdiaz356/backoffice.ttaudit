<?php

namespace App\Http\Controllers\Api\Ttaudit;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{
    //

    public function getCompanies(){


      return Company::all();
    }


    public function getResposeProductsAuditResult(Request $request){

        $company_id = $request->get('company_id');
        $store_id = $request->get('store_id');
        $orden = $request->get('orden');

        $result = DB::table('poll_details')
            ->select(
                "poll_details.store_id",
                "poll_details.company_id",
                "poll_details.result",
                "poll_details.road_id",
                "poll_details.product_id",
                "products.fullname",
                "polls.question",
                "poll_details.poll_id",
                "products.imagen",
                "products.image_link_ext"
            )
            ->leftJoin('polls', 'poll_details.poll_id', '=', 'polls.id')
            ->leftJoin('products', 'poll_details.product_id', '=', 'products.id')
            ->where("poll_details.company_id",$company_id)
            ->where("poll_details.store_id",$store_id)
            ->whereIn("polls.orden",[4,7,50])
            ->get();

        return $result;

    }
    public function getBrandsForCompanyCategory(Request $request)
    {

        $company_id= $request->get('company_id');
        $publicity_id = $request->get('publicity_id');

        $sql= "select id,fullname from products where id in (select product_id from stock_product_pop
               where company_id=".$company_id." and publicity_id=".$publicity_id.")  order by fullname DESC";
        $poll_details = DB::select($sql);
        return $poll_details;
    }
    public function getProductsAuditPreview(Request $request){


        $store_id = $request->get('store_id');
        $category_product_id = $request->get('category_product_id');



        $result = DB::select("SELECT
                                poll_details.id,
                              poll_details.poll_id,
                              poll_details.store_id,
                              poll_details.company_id,
                              poll_details.product_id,
                              poll_details.category_product_id,
                              polls.question,
                              products.fullname,
                              CONCAT('https://ttaudit.com/media/fotos/',medias.archivo) as photo
                            FROM
                              poll_details
                              INNER JOIN polls ON (poll_details.poll_id = polls.id)
                              LEFT OUTER JOIN products ON (poll_details.product_id = products.id)
                              LEFT OUTER JOIN medias ON (poll_details.store_id = medias.store_id)
                              AND (poll_details.poll_id = medias.poll_id)
                              AND (poll_details.company_id = medias.company_id)
                              AND (poll_details.product_id = medias.product_id)
                            WHERE
                              poll_details.company_id = (SELECT   companies.id FROM   companies WHERE  companies.study_id = 6 AND   companies.group_app = 2 AND   companies.previous_company = 1)
                              AND poll_details.store_id = $store_id
                              AND poll_details.category_product_id = $category_product_id
                              AND polls.orden IN (4,50)
                               group by
                                          poll_details.product_id");


        return $result;

    }

    public function getFotoExito(Request $request){


        $store_id = $request->get('store_id');
        $category_product_id = $request->get('category_product_id');



        $result = DB::select("SELECT
                                poll_details.id,
                              poll_details.poll_id,
                              poll_details.store_id,
                              poll_details.company_id,
                              poll_details.product_id,
                              poll_details.category_product_id,
                              polls.question,
                              products.fullname,
                              CONCAT('https://ttaudit.com/media/fotos/',medias.archivo) as photo
                            FROM
                              poll_details
                              INNER JOIN polls ON (poll_details.poll_id = polls.id)
                              LEFT OUTER JOIN products ON (poll_details.product_id = products.id)
                              LEFT OUTER JOIN medias ON (poll_details.store_id = medias.store_id)
                              AND (poll_details.poll_id = medias.poll_id)
                              AND (poll_details.company_id = medias.company_id)
                              AND (poll_details.product_id = medias.product_id)
                            WHERE
                              poll_details.company_id = (SELECT   companies.id FROM   companies WHERE  companies.study_id = 6 AND   companies.group_app = 2 AND   companies.previous_company = 1)
                              AND poll_details.store_id = $store_id
                              AND poll_details.category_product_id = $category_product_id
                              AND polls.orden IN (4,50)
                               group by
                                          poll_details.product_id");


        return $result;

    }


    public function getFotoExitoForPoll(Request $request){


        $orden = $request->get('orden');
        $store_id = $request->get('store_id');
        $product_id = $request->get('product_id');



        $result = DB::select("SELECT
          `medias`.`store_id`,
          `medias`.`poll_id`,
          `polls`.`question`,
          `medias`.`product_id`,
          `medias`.`company_id`,
          `medias`.`category_product_id`,
          `medias`.`archivo`,
          CONCAT('https://ttaudit.com/media/fotos/',medias.archivo) as photo
        FROM
          `polls`
          RIGHT OUTER JOIN `medias` ON (`polls`.`id` = `medias`.`poll_id`)
          INNER JOIN `companies` ON (`medias`.`company_id` = `companies`.`id`)
        WHERE
          `companies`.`study_id` = 6 AND
          `companies`.`group_app` = 2 AND
          `companies`.`previous_company` = 1 AND
          `polls`.`media` = 1 AND
          `polls`.`orden` = $orden AND
          `medias`.`product_id` = $product_id AND
          `medias`.`store_id` =$store_id ");


        return $result;

    }

}
