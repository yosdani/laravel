<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/11/2021
 * Time: 11:32 AM
 */

namespace App\Http\Controllers;



use App\News;
use App\Http\Controllers\Controller;
use App\NewsImage;
use Faker\Provider\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
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
     *
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' =>true,
            'news' => News::select('news.*')->with('images')->paginate(15)
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
            'content' => 'required|string|max:255',
            'category_id' => 'required|integer',

        ]);
    }

    /**
     * Get news by id
     *
     * @param int $id
     * @return JsonResponse
     *
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
     * Create a news
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->json()->all();

        $news = News::create($request->except('img'));
        $news->user_id = Auth::user()->id;
        $news->category_id = $request->category_id;
        $news->save();
        if ($request->images) {
            foreach ($request->images as $image) {
               $this->saveImage($image, $news->id);
            }
        }

        $result = News::where('id', $news->id)->with('images')->get();

        return response()->json($result, 200);
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
        $news->content = $request->get('content');
        $news->category_id = $request->category_id;

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
        $parts = explode('/',$base64Image);
        $ext = explode(';', $parts[1])[0];

        return ($full) ? $ext : null;
    }

    /**
     * Store to image in Storage
     * @param string $base64Image
     * @param int $id
     * @return void
     */
    public function saveImage(string $base64Image, $id)
    {
        $img = $this->getB64Image($base64Image);

        $imgExtension = $this->getB64Extension($base64Image);
        $imageName = 'news_image' .uniqid(). time() . '.' . $imgExtension;
        Storage::disk('local')->put(News::IMAGE_PATH.$imageName, $img);

        $image = new NewsImage();
        $image->image = $imageName;
        $image->news_id = $id;

        $image->save();
    }

}
