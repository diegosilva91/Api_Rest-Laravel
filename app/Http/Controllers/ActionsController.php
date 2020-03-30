<?php

namespace App\Http\Controllers;

use App\Actions;
use App\Http\Resources\ActionResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Actions[]|Collection
     */
    public function index()
    {
        return Actions::paginate(25);
    }

    /**
     * Display historic
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function historic(Request $request){
        $year=Carbon::now()->format('Y')-1;
        $month=Carbon::now()->format('m');
        if ($request->has('name')) {
            return ActionResource::collection(Actions::orderBy('created_at', 'desc')
                ->where('name', 'like',$request->input('name').'%')
                ->with(['Price'=>function($query) use ($month, $year) {
                    $query
                        ->whereYear('created_at','>=',$year)
                        ->whereMonth('created_at','>=',$month);
                }])
                ->paginate(25));
        }
        return ActionResource::collection(Actions::orderBy('created_at', 'desc')
            ->with(['Price'=>function($query) use ($month, $year) {
                $query
                ->whereYear('created_at','>=',$year)
                ->whereMonth('created_at','>=',$month);
            }])
            ->paginate(25));
    }
    /**
     * Display historic by action id
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function historicId($id){
        $year=Carbon::now()->format('Y')-1;
        $month=Carbon::now()->format('m');
        return ActionResource::collection(Actions::where('id', $id)
            ->with(['Price'=>function($query) use ($month, $year) {
                $query
                    ->whereYear('created_at','>=',$year)
                    ->whereMonth('created_at','>=',$month);
            }])
            ->paginate(25));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $action = Actions::create([
            'name'=>$request->name,
            'unique_code'=>$request->unique_code,
            'description'=>$request->description,
            'logo'=>$request->logo,
            'created_at' => $request->created_at,
            'updated_at' =>$request->updated_at,
        ]);
        return new ActionResource($action);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Actions::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        $action=Actions::find($id);
        if(!$action){
            return response()->json(['error'=>array([
                'code'=>404,
                'message'=>'Can no t find it'],404
            )]);
        }
        $action->name=$request->name;
        $action->unique_code=$request->unique_code;
        $action->description=$request->description;
        $action->logo=$request->logo;
        $action->created_at = $request->created_at;
        $action->updated_at=$request->updated_at;
        $action->save();
        return new ActionResource($action);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        $action=Actions::find($id);
        if(!$action){
            return response()->json(['error'=>array([
                'code'=>404,
                'message'=>'Can no t find it'],404
            )]);
        }
        $action->delete();
        return response()->json(['code'=>204,
            'message'=>'Delete correctly'],204);
    }
}
