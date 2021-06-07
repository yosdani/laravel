<?php

namespace App\Http\Controllers\Api;

use App\Tags;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller{
    /**
     * List of tags
     * @OA\Get(
     *      path="/tags",
     *      tags={"Tags"},
     *      summary="Get list of tags",
     *      description="Returns list of tags",
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
        'Tags' => Tags::paginate(15)
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
     * Get tags by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/tags/{id}",
     *      tags={"Tags"},
     *      summary="Get a tags by id",
     *      description="Returns the tags",
     *     @OA\Parameter(
     *          name="id",
     *          description="tags id",
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
     *          description="The tags not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $tags=Tags::find($id);

        if (!$tags) {
            return response()->json("This tags is not exist", '400');
        }

        return response()->json($tags, 200) ;
    }

    /**
     * Create a new Tags
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/tags",
     *      tags={"Tags"},
     *      summary="Create a new tags",
     *      description="Returns created tags",
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
        $tags = Tags::create($request->all());

        return response()->json($tags, 200);
    }

    /**
     * Update the existing tags by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/tags/{id}",
     *      tags={"Tags"},
     *      summary="Update a tags",
     *      description="Returns updated tags",
     *     @OA\Parameter(
     *          name="id",
     *          description="Tags id",
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

        $tags = Tags::find($id);

        if (!$tags) {
            return response()->json("This tags is not exist", '400');
        }

        $tags->name = $parameters['name'];

        $tags->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing tags
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/tags/{id}",
     *      tags={"Tags"},
     *      summary="Delete a tags",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Tags id",
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
        $tags = Tags::find($id);

        if (!$tags) {
            return response()->json("This tags is not exist", '400');
        }

        Tags::destroy($id);

        return  response()->json('deleted', 200);
    }
}
