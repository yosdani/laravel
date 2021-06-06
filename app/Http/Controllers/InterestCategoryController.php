<?php

namespace App\Http\Controllers;

use App\InterestCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InterestCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *  @OA\Get (
     *  path="/interest_categories",
     * tags={"Interest Categories"},
     * operationId="getInterestCategories",
     * summary="Get the list of interest categories",
     * description="When the user has been logged in for the first time, will be show all interest categories and him select one or many of this categories",
     *      @OA\Response(
     *          response=200,
     *          description="Show all interest categories",
     *
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="The token is not valid",
     *      ),
     * )
     *
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' => true,
            'interest_categories' => InterestCategory::all()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $newInterestCategory = new InterestCategory();

        $newInterestCategory->name = $request->name;
        $newInterestCategory->save();

        return response()->json([
            'success' => true,
            'new interest category' => $newInterestCategory
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     *  @OA\Get (
     *  path="/interest_categories/{id}",
     * tags={"Interest Categories"},
     * operationId="getInterestCategoryById",
     * summary="Get by id the interest category",
     * description="Get the category of the user",
     * @OA\Parameter(
     *          name="id",
     *          description="interest category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Show all interest categories",
     *
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="The id is not found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="The token is not valid",
     *      ),
     * )
     */
    public function show($id): JsonResponse
    {
        if (!InterestCategory::find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified id does not exist'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'interest_category' => InterestCategory::find($id)
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
        if (!InterestCategory::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        } else {
            InterestCategory::find($id)->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'The interest category has been updated successfully'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (!InterestCategory::find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'The specified id does not exist'
            ], 400);
        } else {
            InterestCategory::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'The interest category was successfully deleted'
            ], 200);
        }
    }
}
