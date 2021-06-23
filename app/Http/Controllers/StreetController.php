<?php

namespace App\Http\Controllers;

use App\Http\Resources\StreetResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Street;

class StreetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $data = Street::paginate(15);
        $entities = StreetResource::collection($data)->response()->getData(true);
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
        $street = Street::create($request->all());

        return response()->json([
            'success' => true,
            'street' => new StreetResource($street)
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
        $street = Street::findOrFail($id);
        return response()->json([
            'success' => true,
            'street' => new StreetResource($street)
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
    public function update(Request $request, $id):JsonResponse
    {
        $street = Street::findOrFail($id);
        $street->update($request->all());

        return response()->json([
            'success' => true,
            'street' => new StreetResource($street)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (!Street::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ]);
        }
            Street::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'The street was successfully deleted'
            ], 200);

    }
}
