<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Matricula;

class MatriculaController extends Controller
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
            'enrollments' => Matricula::all()
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
            'enrollment' => Matricula::create($request->all())
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
        if (!Matricula::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'enrollment'=>Matricula::find($id)
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
        if (!Matricula::find($id)) {
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'enrollment' => Matricula::find($id)->update($request->all())
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
        if (!Matricula::find($id)) {
            return response()->json([
                'success' =>false,
                'message' =>'The specified id does not exist'
            ], 400);
        }
        Matricula::destroy($id);

        return response()->json([
            'success' =>true,
            'message' =>'The enrollment was successfully deleted'
        ]);
    }
}

