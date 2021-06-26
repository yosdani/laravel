<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/11/2021
 * Time: 11:32 AM
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\NewsResource;
use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class NewsController  extends Controller
{
    /**
     * List of news
     * @return JsonResponse
     * @OA\Get (
     *      path="/news",
     *      tags={"News"},
     *      summary="News",
     *      description="List of all news",
     *      @OA\Response(
     *          response=200,
     *          description="List of all news",
     *          @OA\JsonContent(ref="#/components/schemas/NewsResource"),
     *
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function index():JsonResponse
    {
        $news = News::with('images')
            ->paginate(15);

        return response()->json([
            'success' =>true,
            'news' => NewsResource::collection($news)
        ], 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',

        ]);
    }

    /**
     * Get news by id
     *
     * @param int $id
     * @return JsonResponse
     *  @OA\Get (
     *      path="/news/{id}",
     *      tags={"News"},
     *      summary="Get a news by id",
     *      description="Returns the new",
     *     @OA\Parameter(
     *          name="id",
     *          description="New id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/News"),
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="The new not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $news = News::where('id', $id)->with('images')->first();
        if (!$news) {
            return response()->json("This news is not exist", '404');
        }

        return response()->json(new NewsResource($news), 200) ;
    }


}
