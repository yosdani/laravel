<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/6/2021
 * Time: 10:56 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List of categories paginated
     *
     */
    public function index():JsonResponse
    {
        $data = Category::paginate(15);
        $categories = CategoryResource::collection($data)->response()->getData(true);
        return response()->json($categories);
    }

    /**
     * List of all categories
     *
     */
    public function all():JsonResponse
    {
        return response()->json([
            'success' =>true,
            'category' => Category::select('category.id','category.name')->get()
        ]);
    }

    /*
     * List of categories
     *
     */
    public function getAll():JsonResponse
    {
        $categories =Category::all(['id','name']);
        return response()->json([
            'success' =>true,
            'category' => $categories
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
     *
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
     *
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
     *
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
     *
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
