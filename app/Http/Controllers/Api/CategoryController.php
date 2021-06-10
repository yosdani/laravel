<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/6/2021
 * Time: 10:56 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List of categories
     * @OA\Get(
     *      path="/category",
     *      tags={"Categories"},
     *      summary="Get list of category",
     *      description="Returns list of category",
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
            'category' => Category::paginate(15)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
    }

    /**
     * Create a new Category
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/category",
     *      tags={"Categories"},
     *      summary="Create a new category",
     *      description="Returns created category",
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
    public function store(Request $request): JsonResponse
    {
        $category = new Category();

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'success' => true,
            'category' => $category
        ], 201);
    }

    /**
     * Get category by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/category/{id}",
     *      tags={"Categories"},
     *      summary="Get a category by id",
     *      description="Returns the category",
     *     @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
     *          description="The category not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        if (!$category = Category::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'category'=>$category
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit(int $id): Response
    {
        //
    }

    /**
     * Update the existing category by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/category/{id}",
     *      tags={"Categories"},
     *      summary="Update a category",
     *      description="Returns updated category",
     *     @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
        if (!$category = Category::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'success' => true,
            'category' => $category
        ], 200);
    }

    /**
     * Delete the existing category
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/category/{id}",
     *      tags={"Categories"},
     *      summary="Delete a category",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Category id",
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
        if (!Category::find($id)) {
            return response()->json([
                'success' =>false,
                'message' =>'The specified id does not exist'
            ], 400);
        }
        Category::destroy($id);

        return response()->json([
            'success' =>true,
            'message' =>'The category was successfully deleted'
        ]);
    }
}
