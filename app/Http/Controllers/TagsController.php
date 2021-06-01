<?php

namespace App\Http\Controllers;

use App\Tags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * Get data of all Types of Tags
     *
     * @return array
     */
    public function index():array
    {
        return Tags::all();
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
     * Get data of an Tags
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function show(int $id): JsonResponse
    {
        $tags=Tags::find($id);

        return response()->json($tags, 200) ;
    }

    /**
     * create a new Tags
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function store(Request $request): JsonResponse
    {
        $tags = Tags::create($request->all());

        return response()->json($tags, 200);
    }

    /**
     * Update an  Tags
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     *
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $parameters = $request->only('name');

        $tags = Tags::find($id);
        $tags->name = $parameters['name'];

        $tags->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete a Tags
     *
     */
    public function destroy(int $id): JsonResponse
    {
        Tags::destroy($id);

        return  response()->json('deleted', 200);
    }
}
