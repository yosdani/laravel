<?php

namespace App\Http\Controllers;

use App\Tags;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * List of tags
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
        'success' =>true,
        'tags' => Tags::paginate(15)
    ], 200);
    }

    /**
     * List of all tags
     * @return JsonResponse
     */
    public function all():JsonResponse
    {
        return response()->json([
        'success' =>true,
        'tags' => Tags::select('tags.id','tags.name')->get()
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
     *
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
     *
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
     *
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
     *
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
