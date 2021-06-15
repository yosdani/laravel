<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/11/2021
 * Time: 11:32 AM
 */

namespace App\Http\Controllers\Api;


use App\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\NoticeImage;
use JWTAuth;


class NewsController  extends Controller
{
    /**
     * List of news
     * @return JsonResponse
     * @OA\Get (
     *      path="/news",
     *      tags={"News"},
     *      summary="News",
     *      description="All news",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
        return response()->json([
            'success' =>true,
            'news' =>
               (new News)->newsByUserId(JWTAuth::parseToken()->authenticate()->id)
             ->with('images')
               ->paginate(15)
        ], 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
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
     *
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
        $news = News::where('id', $id)->with('images')->get();
        if (!$news) {
            return response()->json("This news is not exist", '404');
        }

        return response()->json($news, 200) ;
    }

    /**
     * Create a News
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/news",
     *      tags={"News"},
     *      summary="Create a news",
     *      description="Returns created news",
     *     @OA\Parameter(
     *          name="request",
     *          description="request all data",
     *          required=true,
     *          in="path",
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
    public function store(Request $request): JsonResponse
    {
        $request->json()->all();

        $news=new News();
        //$news = News::create($request->except('img'));
      $news->title=$request->title;
      $news->subTitle=$request->subTitle;
      $news->subTitle=$request->subTitle;
      $news->content=$request->contents;
      $news->user_id=JWTAuth::parseToken()->authenticate()->id;
      $news->save();
        $files= array();
        if ($request->img) {
            foreach ($request->img as $image) {
                $files[] = $image;

                $this->saveImage($image, $news->id);
            }
        }

        $news1=News::where('id', $news->id)->with('images')->get();

        return response()->json($news1, 200);
    }

    /**
     * Update the existing news by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id):JsonResponse
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json("This news is not exist", '404');
        }

        $news->title = $request->title;
        $news->subtitle = $request->subtitle;
        $news->content = $request->contents;

        $news->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing news
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json("This news is not exist", '400');
        }

        News::destroy($id);

        return  response()->json('deleted', 200);
    }



    /**
     * Get to image in base64 decode
     * @param string $base64Image
     *
     * @return false|string
     */
    public function getB64Image(string $base64Image)
    {
        $imageServiceStr = substr($base64Image, strpos($base64Image, ",")+1);
        return base64_decode($imageServiceStr);
    }

    /**
     * Get to image in base64 extension
     * @param string $base64Image
     *
     * @return array
     */

    public function getB64Extension(string $base64Image, $full=null)
    {
        preg_match("/^data:image\/(.*);base64/i", $base64Image, $imgExtension);

        return ($full) ? $imgExtension[0] : $imgExtension[1];
    }

    /**
     * Store to image in Storage
     * @param string $base64Image
     * @param $id
     * @return void
     */
    public function saveImage(string $base64Image, $id)
    {
        $img = $this->getB64Image($base64Image);

        $imgExtension = $this->getB64Extension($base64Image);
        $imageName = 'news_image' .uniqid(). time() . '.' . $imgExtension;
        Storage::disk('local')->put($imageName, $img);
        $url=$this->imageUrl($imageName);
        $image = new NoticeImage();
        $image->image = $imageName;
        $image->news_id = $id;
        $image->urlImage =$url;
        $image->save();
    }

    private function imageUrl($fileName)
    {
        return Storage::url($fileName,'storage');
    }

}
