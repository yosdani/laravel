<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:32 PM
 */

namespace App\Http\Controllers;

use App\Http\Resources\IncidenceResource;
use App\Incidence;
use App\Http\Controllers\Controller;
use App\IncidenceImage;
use App\Notifications\IncidenceEditedNotification;
use Exception;
use Faker\Provider\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\IncidenceMails;
use App\User;

/**
 * Class IncidenceController
 */
class IncidenceController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $incidences = [];
        $user = Auth::user();
        $area = $user->area;
        if($user->hasRole('Admin')){
            $incidences = Incidence::with('user')->paginate(15);
        }elseif ($user->hasRole('Responsable')){
            $incidences = Incidence::where('area_id',$area->id)->with('user')->paginate(15);
        }

        return response()->json([
            'success' =>true,
            'incidences' => IncidenceResource::collection($incidences)
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
            'title' => 'required|string|max:255',

        ]);
    }

    /**
     * Get incidence by id
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function show(int $id): JsonResponse
    {
        if (!Incidence::find($id)) {
            return response()->json("This incidence does not exist", '404');
        }
        return response()->json(Incidence::find($id)->with('images')->first(), 200) ;
    }

    /**
     * Create a new incidence
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->json()->all();

        $incidence = Incidence::create($request->except('img'));

        if ($request->img) {
            $files[] = $request->img;
            foreach ($files as $file) {
                $this->saveImage($file, $incidence->id);
            }
        }
        $incidence1=Incidence::where('id', $incidence->id)->with('images')->get();

        return response()->json($incidence1, 200);
    }

    /**
     * Update the existing incidence by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     *
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $incidence = Incidence::find($id);
        if (!$incidence) {
            return response()->json("This incidence does not exist", '400');
        }

        $incidence->update($request->all());
        $incidence->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing incidence
     * @param int $id
     * @return JsonResponse
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $incidence = Incidence::find($id);

        if (!$incidence) {
            return response()->json("This incidence does not exist", '400');
        }

        Incidence::destroy($id);
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
     * @param null $full
     * @return array
     */

    public function getB64Extension(string $base64Image, $full=null): array
    {
        preg_match("/^data:image\/(.*);base64/i", $base64Image, $imgExtension);

        return ($full) ?  $imgExtension[0] : $imgExtension[1];
    }

    /**
     * Store to image in Storage
     * @param string $base64Image
     * @param $id
     * @return void
     */
    public function saveImage(string $base64Image, $id)
    {
        $img =$this->getB64Image($base64Image);

        $imgExtension = $this->getB64Extension($base64Image);
        $imageName = 'incidence_image'. time() . '.' . $imgExtension;

        Storage::disk('local')->put($imageName, $img);
        $url=public_path().'\storage\ '.$imageName;
        $image=new IncidenceImage();
        $image->image=$imageName;
        $image->idIncidence=$id;
        $image->urlImage=$url;
        $image->save();
    }

    /**
     * Export incidence
     * @return JsonResponse
     * 
     */
    public function export():JsonResponse
    {
        $json_data = Incidence::export();

        return response()->json([
            'incidences' => $json_data
        ]);
    }
}
