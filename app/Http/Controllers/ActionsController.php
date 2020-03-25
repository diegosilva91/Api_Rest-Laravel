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
                ->where('name', $request->input('name'))
                ->whereYear('created_at','>=',$year)
                ->whereMonth('created_at','>=',$month)
                ->with('Price')
                ->paginate(25));
        }
        return ActionResource::collection(Actions::orderBy('created_at', 'desc')
            ->whereYear('created_at','>=',$year)
            ->whereMonth('created_at','>=',$month)
            ->with('Price')
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
    }
}
