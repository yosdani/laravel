<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Http\Resources\EquipmentResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = Equipment::paginate(15);
        $entities = EquipmentResource::collection($data)->response()->getData(true);
        return response()->json($entities);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'equipment' => Equipment::create($request->all())
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function show(Equipment $equipment): JsonResponse
    {
        return response()->json(new EquipmentResource($equipment));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Equipment $equipment
     * @return Response
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function update(Request $request, Equipment $equipment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'equipment' => $equipment->update($request->all())
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
       $equipment->delete();

        return response()->json([
            'success' =>true,
            'message' =>'The equipment was successfully deleted'
        ]);
    }
}
