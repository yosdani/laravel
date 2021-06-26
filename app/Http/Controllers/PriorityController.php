<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriorityResource;
use App\Priority;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = Priority::paginate(15);
        $entities = PriorityResource::collection($data)->response()->getData(true);
        return response()->json($entities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'equipment' => Priority::create($request->all())
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json(new PriorityResource(Priority::findOrFail($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Priority $priority
     * @return Response
     */
    public function edit(Priority $priority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $priority = Priority::findOrFail($id);
        $priority->update($request->all());

        return response()->json([
            'success' => true,
            'equipment' => new PriorityResource($priority)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Priority $priority
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Priority $priority): JsonResponse
    {
        $priority->delete();

        return response()->json([
            'success' =>true,
            'message' =>'The priority was successfully deleted'
        ]);
    }
}
