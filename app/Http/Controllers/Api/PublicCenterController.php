<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PublicCenter;
use Illuminate\Http\JsonResponse;

class PublicCenterController extends Controller
{
    /**
     * List of public Center
     * @OA\Get(
     *      path="/publiccenter",
     *      tags={"Public Center"},
     *      summary="Get list of public Center",
     *      description="Returns list of public Center",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation")
     *       )
     *     )
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' =>true,
            'public_centers' => PublicCenter::paginate(15)
        ], 200);
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
     *  * @OA\Post (
     *      path="/publiccenter",
     *      tags={"PublicCenter"},
     *      summary="Create a new Public Center",
     *      description="Returns created Public Center",
     *     @OA\Parameter(
     *          name="request",
     *          description="request all data",
     *          required=true,
     *          in="path",
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
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
     * @OA\Get (
     *      path="/publiccenter/{id}",
     *      tags={"PublicCenter"},
     *      summary="Get a Public Center by id",
     *      description="Returns the public center",
     *     @OA\Parameter(
     *          name="id",
     *          description="PublicCenter id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="The public center not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
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
            'public center'=>PublicCenter::find($id)
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
     * @OA\Put(
     *      path="/publiccenter/{id}",
     *      tags={"PublicCenter"},
     *      summary="Update a public center",
     *      description="Returns updated public center",
     *     @OA\Parameter(
     *          name="id",
     *          description="PublicCenter id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
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
     * @OA\Delete  (
     *      path="/publiccenter/{id}",
     *      tags={"PublicCenter"},
     *      summary="Delete a Public Center",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="PublicCenter id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
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
