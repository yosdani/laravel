<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\District;

class DistrictController extends Controller
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
            'districts' => District::all()
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
    public function store(Request $request):JsonResponse
    {
        $district = District::create($request->all());

        return response()->json([
            'success' => true,
            'district' => $district
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        if( !District::find($id) ){
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'district' => District::find($id)
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        if( !District::find($id) ){
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ]);
        }

        return response()->json([
            'success' => true,
            'district' => District::find($id)->update($request->all())
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
        if( !District::find($id) ){
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ]);

            District::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'The district was successfully deleted'
            ]);
        }
    }
}
