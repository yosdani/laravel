<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:28 AM
 */

namespace App\Http\Controllers;

use App\Area;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * List of areas
     * @OA\Get(
     *      path="/areas",
     *      tags={"Areas"},
     *      summary="Get list of areas",
     *      description="Returns list of areas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation")
     *       )
     *     )
     */
    public function index()
    {
        return response()->json([
            'success' =>true,
            'incidences' => Area::all()
        ], 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',

        ]);
    }

    /**
     * Get area by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/area/{id}",
     *      tags={"Areas"},
     *      summary="Get a area by id",
     *      description="Returns the area",
     *     @OA\Parameter(
     *          name="id",
     *          description="Area id",
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
     *          response=404,
     *          description="The area not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $area=Area::find($id);

        if (!$area) {
            return response()->json("This area is not exist", '404');
        }

        return response()->json($area, 200) ;
    }

    /**
     * Create a new Area
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/areas",
     *      tags={"Areas"},
     *      summary="Create a new area",
     *      description="Returns created area",
     *     @OA\Parameter(
     *          name="request",
     *          description="request all data",
     *          required=true,
     *          in="path",
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
    public function store(Request $request): JsonResponse
    {
        $area = Area::create($request->all());

        return response()->json($area, 200);
    }

    /**
     * Update the existing area by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/areas/{id}",
     *      tags={"Areas"},
     *      summary="Update a area",
     *      description="Returns updated area",
     *     @OA\Parameter(
     *          name="id",
     *          description="Area id",
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
    public function update(Request $request, int $id): JsonResponse
    {
        $parameters = $request->only('name');

        $area = Area::find($id);
        if (!$area) {
            return response()->json("This area is not exist", '400');
        }
        $area->name = $parameters['name'];

        $area->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing area
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/areas/{id}",
     *      tags={"Areas"},
     *      summary="Delete a area",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Area id",
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
    public function destroy(int $id): JsonResponse
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json("This area is not exist", '400');
        }
        Area::destroy($id);

        return  response()->json('deleted', 200);
    }
}
