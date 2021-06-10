<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/7/2021
 * Time: 12:24 AM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Enrolment;

class EnrolmentController extends Controller
{
    /**
     * List of enrollments
     * @return JsonResponse
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
     * 
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
     * 
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
     * 
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
     * 
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
