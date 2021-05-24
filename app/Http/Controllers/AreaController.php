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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * @OA\Get(
     *      path="/areas",
     *      operationId="getAreasList",
     *      tags={"Areas"},
     *      summary="Get list of areas",
     *      description="Returns list of areas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return Area::all();
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
     * Get data of an Area
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/areas/{id}",
     *      operationId="getArea",
     *      tags={"Areas"},
     *      summary="Get an Area entity",
     *      description="Returns Area data",
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
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $area=Area::find($id);

        return response()->json($area, 200) ;
    }

    /**
     * create a new Area
     * @param Request $request
     *
     * @return JsonResponse
     * @OA\Post (
     *      path="/areas/{id}",
     *      operationId="createArea",
     *      tags={"Areas"},
     *      summary="Create an Area entity",
     *      description="Returns created Area data",
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
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $area = Area::create($request->all());

        return response()->json($area, 200);
    }

    /**
     * Update an  Area
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Put(
     *      path="/areas/{id}",
     *      operationId="updateArea",
     *      tags={"Areas"},
     *      summary="Update an Area entity",
     *      description="Returns updated Area data",
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
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $parameters = $request->only('name');

        $area = Area::find($id);
        $area->name = $parameters['name'];

        $area->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete a Area
     *
     * @param int $id
     * @return JsonResponse
     *
     *  @OA\Delete  (
     *      path="/areas/{id}",
     *      operationId="deleteArea",
     *      tags={"Areas"},
     *      summary="Delete an Area entity",
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
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        Area::destroy($id);

        return  response()->json('deleted', 200);
    }
}
