<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:32 PM
 */

namespace App\Http\Controllers\Api;

use App\Incidence;
use App\Http\Controllers\Controller;
use App\IncidenceImage;
use Faker\Provider\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


/**
 * Class IncidenceController
 */
class IncidenceController extends Controller
{
    /**
     * List of incidences
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
     * @OA\Get (
     *      path="/incidence/{id}",
     *      tags={"Incidences"},
     *      summary="Get a incidence by id",
     *      description="Returns the incedence",
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

        $incidence=Incidence::where('id',$id)->with('images')->get();

        if (!$incidence) {
            return response()->json("This incidence is not exist", '404');
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

        $incidence = Incidence::create($request->except('img'));


        $files= array();
        if($request->img) {
            foreach ($request->img as $image) {

                $files[] = $image;

                $this->saveImage($image, $incidence->id);
            }


        }
        $incidence1=Incidence::where('id',$incidence->id)->with('images')->get();

        return response()->json($incidence1, 200);
    }


    /**
     * Update the existing incidence by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @OA\Put(
     *      path="/incidence/{id}",
     *      tags={"Incidences"},
     *      summary="Update a incidence",
     *      description="Returns updated incidence",
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


        return response()->json('updated', 200);
    }

    /**
     * Delete the existing incidence
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/incidence/{id}",
     *      tags={"Incidences"},
     *      summary="Delete a incidence",
     *      description="Returns Json response",
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
     * @param  string $base64Image
     *
     * @return false|string
     */
    public function getB64Image(string $base64Image){
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

        preg_match("/^data:image\/(.*);base64/i",$base64Image, $imgExtension);

        return ($full) ?  $imgExtension[0] : $imgExtension[1];

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
        $imageName = 'incidence_image' .uniqid(). time() . '.' . $imgExtension;
        Storage::disk('local')->put($imageName, $img);
        $url=$this->imageUrl($imageName);
        $image = new IncidenceImage();
        $image->image = $imageName;
        $image->incidence_id = $id;
        $image->urlImage =$url;
        $image->save();
    }

    private function imageUrl($fileName)
    {
        return Storage::url($fileName);
    }



}
