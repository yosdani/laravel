<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Tag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class TagController extends Controller
{
    /**
     * List of tags
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $data = Tag::paginate(15);
        $entities = TagResource::collection($data)->response()->getData(true);
        return response()->json($entities);
    }

    /**
     * List of all tags
     * @return JsonResponse
     */
    public function all():JsonResponse
    {
        return response()->json(TagResource::collection(Tag::all()));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data): Validator
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
        $tag = Tag::findOrFail($id);

        return response()->json(new TagResource($tag)) ;
    }

    /**
     * Create a new Tag
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function store(Request $request): JsonResponse
    {
        $tag = Tag::create($request->all());

        return response()->json(new TagResource($tag));
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

        $tags = Tag::findOrFail($id);

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
        $tags = Tag::find($id);

        if (!$tags) {
            return response()->json("This tags is not exist", '400');
        }

        Tag::destroy($id);

        return  response()->json('deleted', 200);
    }
}
