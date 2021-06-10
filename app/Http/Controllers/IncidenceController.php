<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:32 PM
 */

namespace App\Http\Controllers;

use App\Incidence;
use App\Http\Controllers\Controller;
use App\IncidenceImage;
use Faker\Provider\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        return response()->json([
            'success' =>true,
            'incidences' => Incidence::with('images')->paginate(15)
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
     * Get incidence by id
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function show(int $id): JsonResponse
    {
        $incidence=Incidence::where('id', $id)->with('images')->get();

        if (!$incidence) {
            return response()->json("This incidence is not exist", '404');
        }
        return response()->json($incidence, 200) ;
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
        $parameters = $request->only(
            'name',
            'assignedTo',
            'reviewer',
            'deadLine',
            'creationDate',
            'tags',
            'description',
            'attachedContent',
            'dni',
            'applicant',
            'phone',
            'centerEnrollment',
            'streetNumber',
            'district',
            'neighborhood',
            'addressee',
            'team',
            'location',
            'responseForCitizen',
            'idState'
        );

        $incidence = Incidence::find($id);
        if (!$incidence) {
            return response()->json("This incidence is not exist", '400');
        }

        $oldState = $incidence->state;

        $incidence->name = $parameters['name'];
        $incidence->assignedTo = $parameters['assignedTo'];
        $incidence->reviewer = $parameters['reviewer'];
        $incidence->deadLine = $parameters['deadLine'];
        $incidence->tags = $parameters['tags'];
        $incidence->description = $parameters['description'];
        $incidence->attachedContentn = $parameters['attachedContent'];
        $incidence->dni = $parameters['dni'];
        $incidence->applicant = $parameters['applicant'];
        $incidence->phone = $parameters['phone'];
        $incidence->centerEnrollment = $parameters['centerEnrollment'];
        $incidence->streetNumber = $parameters['streetNumber'];
        $incidence->district = $parameters['district'];
        $incidence->neighborhood = $parameters['neighborhood'];
        $incidence->address = $parameters['address'];
        $incidence->team = $parameters['team'];
        $incidence->location = $parameters['location'];
        $incidence->responseForCitizen = $parameters['responseForCitizen'];
        $incidence->state = $parameters['idState'];
        $incidence->save();

        if ($oldState != $incidence->state) {
            try {
                \Mail::to(User::find($incidence->user_id)->email)->send(new IncidenceMails($incidence, $incidence1[0]->images[0]->urlImage, 'La Incidencia a cambiado al estado: '+ State::find($incidence->state)->name));
            } catch (Exception $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception
                ]);
            }
        }

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
            return response()->json("This incidence is not exist", '400');
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
}
