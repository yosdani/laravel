<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/6/2021
 * Time: 10:56 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ImageController extends Controller
{
    /**
     * Get an Image
     * @OA\Get(
     *      path="/image/{source}/{filename}",
     *      tags={"Images"},
     *      summary="Get an image with all details",
     *      description="Returns response",
     *      @OA\Parameter(
     *          name="source",
     *          description="Indicates if the image if of a News or of an Incidence",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="filename",
     *          description="Name of th image",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/IncidenceImage"),
     *
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     *
     *       )
     *     )
     */
    public function image($source, $filename): \Illuminate\Http\Response
    {
        $path = storage_path('app/public/images/'.$source.'/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }


        $file = File::get($path);
        $type = File::mimeType($path);
        return Response::make($file, 200, ["Content-Type" => $type]);
    }



}
