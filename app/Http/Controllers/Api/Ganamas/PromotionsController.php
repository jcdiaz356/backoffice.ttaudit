<?php

namespace App\Http\Controllers\Api\Ganamas;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $promotions = Promotion::all();

        return  $promotions;
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
        $promotion = Promotion::with('promotionDetails')->find($id);

        return $promotion ;
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


    public function  promotionsForZone(Request $request){

        $promotion_id = $request->get('promotion_id') ;
        $zone_id = $request->get('zone_id') ;

       //-- Promotion::with('promotionDetails')

//        $promotion= Promotion::where('promotion_id',$promotion_id)
//            ->where('zone_id',$zone_id)
//            ->get();
        $promotion= Promotion::find($promotion_id)
            ->with(['promotions_details' => function ($q) use($zone_id,$promotion_id) {
              //  $q->whereHas('types', function($q) use($SpecificID) {
                    $q->where('zone_id', $zone_id)->where('promotion_id',$promotion_id);

               // });
            }]);



        return  $promotion;


    }





}
