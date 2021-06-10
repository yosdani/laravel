<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/23/2021
 * Time: 6:54 AM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notice;
use App\NoticeImage;
use Faker\Provider\Image;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /**
     * List of notices
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' =>true,
            'notices' => Notice::with('images')->paginate(15)
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
            'name' => 'required|string|max:255',
            'textNotice' => 'required|string|max:255',

        ]);
    }

    /**
     * Get notice by id
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function show(int $id): JsonResponse
    {

        $notice = Notice::where('id', $id)->with('images')->get();
        if (!$notice) {
            return response()->json("This notice is not exist", '404');
        }

        return response()->json($notice, 200) ;
    }

    /**
     * Create a new notice
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->json()->all();

        $notice = Notice::create($request->except('img'));


        $files= array();
        if($request->img) {
            foreach ($request->img as $image) {

                $files[] = $image;

                $this->saveImage($image, $notice->id);
            }


        }

        $notice1=Notice::where('id',$notice->id)->with('images')->get();

        return response()->json($notice1, 200);
    }

    /**
     * Update the existing notice by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id):JsonResponse
    {

        $notice = Notice::find($id);

        if (!$notice) {
            return response()->json("This notice is not exist", '404');
        }

        $notice->name = $request->name;
        $notice->texNotice = $request->texNotice;

        $notice->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing notice
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $notice = Notice::find($id);

        if (!$notice) {
            return response()->json("This notice is not exist", '400');
        }

        Notice::destroy($id);

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
        public function saveImage( string $base64Image,$id)
    {

        $img = $this->getB64Image($base64Image);

        $imgExtension = $this->getB64Extension($base64Image);
        $imageName = 'notice_image' .uniqid(). time() . '.' . $imgExtension;
        Storage::disk('local')->put($imageName, $img);
        $url=$this->imageUrl($imageName);
        $image = new NoticeImage();
        $image->image = $imageName;
        $image->notice_id = $id;
        $image->urlImage =$url;
        $image->save();
    }

    private function imageUrl($fileName)
    {
        return Storage::url($fileName);
    }

}
