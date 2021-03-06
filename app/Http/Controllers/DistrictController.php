<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistrictResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\District;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = District::paginate(15);
        $entities = DistrictResource::collection($data)->response()->getData(true);
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
        $district = new District();
        $district->district = $request->name;
        $district->save();

        return response()->json([
            'success' => true,
            'district' => $district
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        if (!District::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'district' => District::find($id)
        ], 200);
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
        if (!District::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        $district = District::find($id);
        $district->district = $request->name;
        $district->save();

        return response()->json([
            'success' => true,
            'district' => $district
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $district = District::find($id);
        if (!$district) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }
            $district->delete();

            return response()->json([
                'success' => true,
                'message' => 'The district was successfully deleted'
            ], 200);

    }
}
