<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/19/2021
 * Time: 9:39 AM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\State;

class StateController extends Controller
{

    /**
     * List of states
     * @OA\Get(
     *      path="/states",
     *      tags={"States"},
     *      summary="Get list of states",
     *      description="Returns list of states",
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
            'states' => State::all()
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
     * Get state by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/states/{id}",
     *      tags={"States"},
     *      summary="Get a state by id",
     *      description="Returns the state",
     *     @OA\Parameter(
     *          name="id",
     *          description="State id",
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
     *          description="The state not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $state=State::find($id);
        if (!$state) {
            return response()->json("This state is not exist", '400');
        }
        return response()->json($state, 200) ;
    }

    /**
     * Create a new State
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/states",
     *      tags={"States"},
     *      summary="Create a new state",
     *      description="Returns created state",
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
        $state = State::create($request->all());

        return response()->json($state, 200);
    }

    /**
     * Update the existing state by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/states/{id}",
     *      tags={"States"},
     *      summary="Update a state",
     *      description="Returns updated state",
     *     @OA\Parameter(
     *          name="id",
     *          description="State id",
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

        $state = State::find($id);
        if (!$state) {
            return response()->json("This state is not exist", '400');
        }
        $state->name = $parameters['name'];

        $state->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing state
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/states/{id}",
     *      tags={"State"},
     *      summary="Delete a state",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="State id",
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
        $state = State::find($id);

        if (!$state) {
            return response()->json("This state is not exist", '400');
        }

        State::destroy($id);

        return  response()->json('deleted', 200);
    }
}
