<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Street;

class StreetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' => true,
            'streets' => Street::all(),
        ], 200);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $street = Street::create($request->all());

        return response()->json([
            'success' => true,
            'street' => $street
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        if (!Street::find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified id does not exist'
            ], 400);
        }
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
    public function update(Request $request, $id):JsonResponse
    {
        if (!Street::find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified id does not exist'
            ]);
        }

        return response()->json([
            'success' => true,
            'street' => Street::find($id)->update($request->all())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (!Street::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ]);

            Street::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'The street was successfully deleted'
            ], 200);
        }
    }
}
