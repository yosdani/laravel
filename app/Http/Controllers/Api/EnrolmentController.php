<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/7/2021
 * Time: 12:24 AM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Enrolment;

class EnrolmentController extends Controller
{
    /**
     * List of enrollments
     * @OA\Get(
     *      path="/enrollment",
     *      tags={"Enrollments"},
     *      summary="Get list of enrollments",
     *      description="Returns list of enrollments",
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
            'enrollments' => Enrolment::all()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Create a new Enrollment
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/enrollment",
     *      tags={"Enrollments"},
     *      summary="Create a new enrollment",
     *      description="Returns created enrollment",
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
            'enrollment' => Enrolment::create($request->all())
        ], 201);
    }

    /**
     * Get enrollment by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/enrollment/{id}",
     *      tags={"Enrollments"},
     *      summary="Get a enrollment by id",
     *      description="Returns the enrollment",
     *     @OA\Parameter(
     *          name="id",
     *          description="Enrollment id",
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
     *          description="The enrollment not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show($id):JsonResponse
    {
        if (!Enrolment::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'enrollment'=>Enrolment::find($id)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the existing enrollment by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/enrollment/{id}",
     *      tags={"Enrollments"},
     *      summary="Update a enrollment",
     *      description="Returns updated enrollment",
     *     @OA\Parameter(
     *          name="id",
     *          description="Enrollment id",
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
    public function update(Request $request, $id):JsonResponse
    {
        if (!Enrolment::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'enrollment' => Enrolment::find($id)->update($request->all())
        ], 200);
    }

    /**
     * Delete the existing enrollment
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/enrollment/{id}",
     *      tags={"Enrollments"},
     *      summary="Delete a enrollment",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Enrollment id",
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
    public function destroy($id):JsonResponse
    {
        if (!Enrolment::find($id)) {
            return response()->json([
                'success' =>false,
                'message' =>'The specified id does not exist'
            ], 400);
        }
        Enrolment::destroy($id);

        return response()->json([
            'success' =>true,
            'message' =>'The enrollment was successfully deleted'
        ]);
    }
}
