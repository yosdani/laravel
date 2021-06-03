<?php

namespace App\Http\Controllers;

use App\Breakdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BreakdownController extends Controller
{
    /**
     * List of breakdowns
     * @OA\Get(
     *      path="/breakdown",
     *      tags={"Breakdown"},
     *      summary="Get list of breakdowns",
     *      description="Returns list of breakdowns",
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
            'breakdowns' => Breakdown::all()
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
     * Get breakdown by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/breakdown/{id}",
     *      tags={"Breakdown"},
     *      summary="Get a breakdown by id",
     *      description="Returns the breakdown",
     *     @OA\Parameter(
     *          name="id",
     *          description="Breakdown id",
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
     *          description="The breakdown not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $breakdown=Breakdown::find($id);

        if (!$breakdown) {
            return response()->json("This breakdown is not exist", '404');
        }
        return response()->json($breakdown, 200) ;
    }

    /**
     * Create a new Breakdown
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/breakdown",
     *      tags={"Breakdown"},
     *      summary="Create a new breakdown",
     *      description="Returns created breakdown",
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
        $breakdown = Breakdown::create($request->all());

        return response()->json($breakdown, 200);
    }

    /**
     * Update the existing breakdown by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/breakdown/{id}",
     *      tags={"Breakdown"},
     *      summary="Update a breakdown",
     *      description="Returns updated breakdown",
     *     @OA\Parameter(
     *          name="id",
     *          description="Breakdown id",
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

        $breakdown = Breakdown::find($id);

        if (!$breakdown) {
            return response()->json("This breakdown is not exist", '400');
        }
        $breakdown->name = $parameters['name'];

        $breakdown->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing breakdown
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/breakdown/{id}",
     *      tags={"Breakdown"},
     *      summary="Delete a breakdown",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Breakdown id",
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
        $breakdown = Breakdown::find($id);

        if (!$breakdown) {
            return response()->json("This breakdown is not exist", '400');
        }
        Breakdown::destroy($id);

        return  response()->json('deleted', 200);
    }
}
