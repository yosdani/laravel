<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicCenterResource;
use Illuminate\Http\Request;
use App\PublicCenter;
use Illuminate\Http\JsonResponse;

class PublicCenterController extends Controller
{
    /**
     * List of public Center
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $data = PublicCenter::paginate(15);
        $entities = PublicCenterResource::collection($data)->response()->getData(true);
        return response()->json($entities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        //
    }

    /**
     * Create a new Public Center
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse
    {
        return response()->json([
            'success' => true,
            'category' => PublicCenter::create($request->all())
        ], 201);
    }

    /**
     * Get Public Center by id
     *
     * @param int $id
     * @return JsonResponse
     *
     *
     */
    public function show(int $id):JsonResponse
    {
        if (!PublicCenter::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'public_center'=>PublicCenter::find($id)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit(int $id): JsonResponse
    {
        //
    }

    /**
     * Update the existing Public Center by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     *
     */
    public function update(Request $request, int $id):JsonResponse
    {
        if (!PublicCenter::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'public center' => PublicCenter::find($id)->update($request->all())
        ], 200);
    }

    /**
     * Delete the existing Public Center
     * @param int $id
     * @return JsonResponse
     *
     */
    public function destroy(int $id):JsonResponse
    {
        if (!PublicCenter::find($id)) {
            return response()->json([
                'success' =>false,
                'message' =>'The specified id does not exist'
            ], 400);
        }
        PublicCenter::destroy($id);

        return response()->json([
            'success' =>true,
            'message' =>'The public center was successfully deleted'
        ]);
    }
}
