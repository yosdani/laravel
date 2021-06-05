<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/23/2021
 * Time: 6:54 AM
 */

namespace App\Http\Controllers;

use App\Notice;
use App\NoticeImage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * List of notices
     * @OA\Get(
     *      path="/notice",
     *      tags={"Notice"},
     *      summary="Get list of notices",
     *      description="Returns list of notices",
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
            'notices' => Notice::with('images')->get()
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
     * @OA\Get (
     *      path="/notice/{id}",
     *      tags={"Notices"},
     *      summary="Get a notice by id",
     *      description="Returns the notice",
     *     @OA\Parameter(
     *          name="id",
     *          description="Notice id",
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
     *          description="The notice not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show($id)
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
     *  * @OA\Post (
     *      path="/notice",
     *      tags={"Notices"},
     *      summary="Create a new notice",
     *      description="Returns created notice",
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
    public function store(Request $request)
    {
        $request->json()->all();

        $notice = Notice::create($request->except('img'));

        $files= array();
        if($request->img) {

            foreach ($request->img as $image) {

                $files[] = $image;


                $this->saveimage($image, $notice->id);

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
     * @OA\Put(
     *      path="/notice/{id}",
     *      tags={"Notices"},
     *      summary="Update a notice",
     *      description="Returns updated notice",
     *     @OA\Parameter(
     *          name="id",
     *          description="notice id",
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
    public function update(Request $request, $id)
    {
        $parameters = $request->only('name, textNotice');

        $notice = Notice::find($id);

        if (!$notice) {
            return response()->json("This notice is not exist", '404');
        }

        $notice->name = $parameters['name'];
        $notice->textNotice = $parameters['textNotice'];

        $notice->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing notice
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/notice/{id}",
     *      tags={"Notices"},
     *      summary="Delete a notice",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Notice id",
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
    public function delete($id)
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
     * @return image
     */
    public function getB64Image($base64Image){
        $imageServiceStr = substr($base64Image, strpos($base64Image, ",")+1);
        $image = base64_decode($imageServiceStr);
        return $image;
    }

    /**
     * Get to image in base64 extension
     * @param string $base64Image
     *
     * @return array
     */

    public function getB64Extension($base64Image, $full=null){

        preg_match("/^data:image\/(.*);base64/i",$base64Image, $imgExtension);

        return ($full) ?  $imgExtension[0] : $imgExtension[1];

    }
    /**
     * Store to image in Storage
     * @param string $base64Image
     *
     * @return void
     */
    public function saveimage($base64Image,$id)
    {

        $img =$this->getB64Image($base64Image);

        $imgExtension = $this->getB64Extension($base64Image);
        $imageName = 'notice_image'. time() .uniqid(). '.' . $imgExtension;

        Storage::disk('local')->put( $imageName, $img);
        $url=public_path().'\storage\ '.$imageName;
        $image=new NoticeImage();
        $image->image=$imageName;
        $image->idNotice=$id;
        $image->urlImage=$url;
        $image->save();
    }
}
