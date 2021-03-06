<?php

namespace App\Http\Controllers;

use App\Http\Resources\NeighborhoodResource;
use Illuminate\Http\Request;
use App\Neighborhood;
use Illuminate\Http\JsonResponse;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $data = Neighborhood::paginate(15);
        $entities = NeighborhoodResource::collection($data)->response()->getData(true);
        return response()->json($entities);
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
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $neighborhood = Neighborhood::create($request->all());

        return response()->json([
            'success' => true,
            'neighborhood' => $neighborhood
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        if (!Neighborhood::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'neighborhood' => Neighborhood::find($id)
        ]);
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
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        if (!Neighborhood::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'neighborhood' => Neighborhood::find($id)->update($request->all())
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (!Neighborhood::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        Neighborhood::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'The neighborhood was successfully deleted'
        ]);
    }
}
