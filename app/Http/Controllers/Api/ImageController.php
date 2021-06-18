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
     * List of categories
     * @OA\Get(
     *      path="/image/{source}/{filename}",
     *      tags={"Images"},
     *      summary="Get an image",
     *      description="Returns list of category",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation")
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

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;
    }



}
