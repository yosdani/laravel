<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' =>true,
            'category' => Category::all()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
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

    public function getToken()
    {
        echo csrf_token();
    }
}

