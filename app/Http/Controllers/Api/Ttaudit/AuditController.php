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
            ->where("polls.orden",$orden)
            ->get();

        return $result;

    }
}
