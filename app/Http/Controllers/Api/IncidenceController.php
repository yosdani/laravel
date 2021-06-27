<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:32 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Resources\IncidenceResource;
use App\Incidence;
use App\Http\Controllers\Controller;
use App\IncidenceImage;
use App\Notifications\IncidenceEditedNotification;
use Faker\Provider\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\IncidenceMails;
use App\State;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class IncidenceController
 */
class IncidenceController extends Controller
{
    /**
     * List of incidences by citizens
     * @return JsonResponse
     * @OA\Get (
     *      path="/incidence",
     *      tags={"Incidences"},
     *      summary="Get all incidences of user",
     *      description="Returns the incedence",
     *      @OA\Response(
     *          response=200,
     *          description="List of all incidences that belongs to a User",
     *          @OA\JsonContent(ref="#/components/schemas/IncidenceResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function index(): JsonResponse
    {
        $incidences = Incidence::where('user_id',JWTAuth::parseToken()->authenticate()->id)->with('images')
            ->paginate(15);
        return response()->json([
            'success' =>true,
            'incidences'=> IncidenceResource::collection($incidences)
        ], 200);
    }

    /**
     * List of incidences by workers
     * @return JsonResponse
     * @OA\Get (
     *      path="/worker/incidence",
     *      tags={"Incidences Worker"},
     *      summary="Get all incidences of workers",
     *      description="Returns the list of incedences related to the authenticated worker",
     *      @OA\Response(
     *          response=200,
     *          description="List of all incedences by workers",
     *          @OA\JsonContent(ref="#/components/schemas/IncidenceResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function indexWorkers(): JsonResponse
    {
        $incidences = Incidence::where('assigned_id',JWTAuth::parseToken()->authenticate()->id)
            ->with('images')
            ->paginate(15);
        return response()->json([
            'success' =>true,
            'incidences'
            => IncidenceResource::collection($incidences)
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
     * @OA\Get (
     *      path="/incidence/{id}",
     *      tags={"Incidences"},
     *      summary="Search a incidence by id",
     *      description="Returns all the details of incidence",
     *     @OA\Parameter(
     *          name="id",
     *          description="Incidence id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Incidence")
     *
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="The incidence not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $incidence=Incidence::where('id', $id)->with('images')->get();

        if (!$incidence) {
            return response()->json("This incidence does not exist", '404');
        }
        return response()->json($incidence, 200) ;
    }

    /**
     * Create a new incidence
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/incidence",
     *      tags={"Incidences"},
     *      summary="Create a new incidence",
     *      description="Returns created incidence",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreIncidenceRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Incidence")
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

        $incidence = Incidence::create($request->except(['img','user_id']));
        $incidence->user_id = JWTAuth::parseToken()->authenticate()->id;
        $incidence->save();


        $files= array();
        if ($request->img) {
            foreach ($request->img as $image) {
                $files[] = $image;

                $this->saveImage($image, $incidence->id);
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
     * @OA\Put(
     *      path="/incidence/{id}",
     *      tags={"Incidences Worker"},
     *      summary="Update a incidence",
     *      description="Returns updated incidence, this endpoint is for worker app",
     *     @OA\Parameter(
     *          name="id",
     *          description="incidence id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Incidence")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *      ),
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $parameters = $request->only(
            'title',
            'assigned_id',
            'deadLine',
            'creationDate',
            'tags',
            'description',
            'attachedContent',
            'applicant',
            'enrolment_id',
            'streetNumber',
            'district',
            'neighborhood',
            'address',
            'team',
            'location',
            'responseForCitizen',
            'idState',
            'area_id'
        );

        $incidence = Incidence::find($id);
        if (!$incidence) {
            return response()->json("This incidence does not exist", '400');
        }

        $incidence->title = $parameters['title'];
        $incidence->assigned_id = $parameters['assignedTo'];
        $incidence->deadLine = $parameters['deadLine'];
        $incidence->tags = $parameters['tags'];
        $incidence->description = $parameters['description'];
        $incidence->attachedContentn = $parameters['attachedContent'];
        $incidence->applicant = $parameters['applicant'];
        $incidence->centerEnrollment = $parameters['centerEnrollment'];
        $incidence->streetNumber = $parameters['streetNumber'];
        $incidence->district = $parameters['district'];
        $incidence->neighborhood = $parameters['neighborhood'];
        $incidence->address = $parameters['address'];
        $incidence->team = $parameters['team'];
        $incidence->location = $parameters['location'];
        $incidence->responseForCitizen = $parameters['responseForCitizen'];
        $incidence->state = $parameters['idState'];
        $incidence->area_id = $parameters['areaId'];
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
     * @param  string $base64Image
     *
     * @return false|string
     */
    public function getB64Image(string $base64Image)
    {
        $imageServiceStr = substr($base64Image, strpos($base64Image, ",")+1);
        $image = base64_decode($imageServiceStr);
        return $image;
    }


    /**
     * Get to image in base64 extension
     * @param string $base64Image
     * @param null $full
     * @return array
     */

    public function getB64Extension($base64Image, $full=null)
    {
        $img = explode(',', $base64Image);
        $ini =substr($img[0], 11);
        $type = explode(';', $ini);

        return $type[0];
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
        $imageName = 'incidence_image' .uniqid(). time() . '.' . $imgExtension;
        Storage::disk('local')->put(Incidence::IMAGE_PATH.$imageName, $img);

        $image = new IncidenceImage();
        $image->image = $imageName;
        $image->incidence_id = $id;

        $image->save();
    }

}
