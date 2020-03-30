<?php

namespace App\Http\Controllers;

use App\Actions;
use App\Http\Resources\PriceResource;
use App\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year=Carbon::now()->format('Y')-1;
        $month=Carbon::now()->format('m');

//        dd($month,$year);
        return PriceResource::collection(Price::orderBy('created_at', 'desc')->whereYear('created_at','>=',$year)->whereMonth('created_at','>=',$month)->with('Actions')->paginate(25));
    }

    /**
     * List of top
     *
     * @return \Illuminate\Http\Response
     */
    public function top(){
        $max_price= \DB::table('prices')->select('actions_id',\DB::raw('MAX(current_quantity) - MIN(current_quantity) AS max_price'))
            ->whereBetween('created_at',[(Carbon::yesterday()),(Carbon::now())])
            ->groupBy('actions_id')
            ->orderBy('max_price','desc');
        $actions = \DB::table('actions')
            ->joinSub($max_price, 'max_price', function ($join) {
                $join->on('actions.id', '=', 'max_price.actions_id');
            });
//        dd($actions);die;
        return $actions->paginate(25);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $price = Price::create([
            'actions_id'=>$request->actions_id,
            'current_quantity'=>$request->current_quantity,
            'created_at' => $request->created_at,
            'updated_at' =>$request->updated_at,
        ]);
        return new PriceResource($price);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
        $prices=Price::find($id);
        if(!$prices){
            return response()->json(['error'=>array([
                'code'=>404,
                'message'=>'Can no t find it'],404
            )]);
        }
        $prices->actions_id=$request->actions_id;
        $prices->current_quantity=$request->current_quantity;
        $prices->created_at = $request->created_at;
        $prices->updated_at =$request->updated_at;
        $prices->save();
        return new PriceResource($prices);
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
}
