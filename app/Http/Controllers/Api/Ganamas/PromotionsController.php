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
        //return  $request;
        //-- Promotion::with('promotionDetails')

        //  $promotion= Promotion::with('promotionDetails')->where('id',$promotion_id)->get();


        // $promotion= Promotion::find($promotion_id)
        //     ->with(['promotionDetails' => function ($q) use($zone_id,$promotion_id) {
        //       //  $q->whereHas('types', function($q) use($SpecificID) {
        //             $q->where('zone_id', $zone_id)->where('promotion_id',$promotion_id);

        //       // });
        //     }]);


        $promotion= Promotion::with(['promotionDetails' => function ($q) use($zone_id,$promotion_id) {

            $q->where('zone_id', $zone_id)->where('promotion_id',$promotion_id);

        }])->where('id',$promotion_id)->first();

        // $promotion= Promotion::find($promotion_id)
        // ->whereHas('promotionDetails', function ($query) use ($zone_id,$promotion_id) {
        //     $query->where('zone_id', $zone_id)->where('promotion_id',$promotion_id);
        // });

        //   $promotion= Promotion::whereHas('promotionDetails', function ($query) use ($zone_id,$promotion_id) {
        //     $query->where('zone_id', $zone_id)->where('promotion_id',$promotion_id);
        // })->where('id',$promotion_id)->first();


        return  $promotion;


    }





}
