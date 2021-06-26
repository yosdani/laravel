<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:32 PM
 */

namespace App\Http\Controllers;

use App\Area;
use App\Equipment;
use App\Http\Resources\AreaResource;
use App\Http\Resources\EnrolmentResource;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\IncidenceResource;
use App\Http\Resources\NeighborhoodResource;
use App\Http\Resources\PriorityResource;
use App\Http\Resources\PublicCenterResource;
use App\Http\Resources\StateResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\UserResource;
use App\Incidence;
use App\Http\Controllers\Controller;
use App\IncidenceImage;
use App\Neighborhood;
use App\Notifications\IncidenceEditedNotification;
use App\Priority;
use App\PublicCenter;
use App\State;
use App\Street;
use App\Tag;
use Exception;
use Faker\Provider\Image;
use Illuminate\Database\Eloquent\Builder;
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
        $user = Auth::user();
        $incidences = [];
        $area = $user->area;
        if($user->hasRole('Admin')){
            $data = Incidence::with('user')->paginate(15);
            $incidences = IncidenceResource::collection($data)->response()->getData(true);
        }elseif ($user->hasRole('Responsable')){
            $data = Incidence::where('area_id',$area->id)->with('user')->paginate(15);
            $incidences = IncidenceResource::collection($data)->response()->getData(true);
        }

        return response()->json($incidences);
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
        $incidence = Incidence::findOrFail($id);

        return response()->json(new IncidenceResource($incidence)) ;
    }

    /**
     * Get incidence, preview and next
     * @param int $id
     * @return JsonResponse
     * 
     * 
     */
    public function getPreviewNext( $id ): JsonResponse
    {
        if( !Incidence::find($id) ){
            return response()->json([
                'success' => false,
                'message' =>'The specified id does not exist'
            ]);
        }
        $all_incidences = Incidence::all()->pluck('id');
        $preview = null;
        $next = null;

        foreach ($all_incidences as $key => $incidence){
            if($incidence == $id){   
                if($all_incidences[0] != $id){
                    $preview = $all_incidences[$key-1];
                }
                if($all_incidences[$all_incidences->count()-1] != $id){
                    $next = $all_incidences[$key+1];
                }
            }
        }

        return response()->json([
            'incidence' => Incidence::where('id','=',$id)->with('area','assignedTo','district','enrolment','neighborhood','publicCenter','state','street','tag','user','images')->first(),
            'preview' => $preview,
            'next' => $next
        ]);
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
        $incidence = Incidence::findOrFail($id);
        $incidence->title = $request->title;
        $incidence->assigned_id = $request->assignedTo;
        $incidence->deadLine = $request->deadLine;
        $incidence->tag_id = $request->tag;
        $incidence->equipment_id = $request->equipment;
        $incidence->priority_id = $request->priority;
        $incidence->description = $request->description;
        $incidence->internalResponse = $request->internalResponse;
        $incidence->enrolment_id = $request->enrolment;
        $incidence->street_id = $request->street;
        $incidence->district_id = $request->district;
        $incidence->neighborhood_id = $request->neighborhood;
        $incidence->address = $request->address;
        $incidence->location = $request->location;
        $incidence->responseForCitizen = $request->responseForCitizen;
        $incidence->state_id = $request->state;
        $incidence->area_id = $request->area;
        $incidence->save();

        if ($request->images) {
            foreach ($request->images as $image) {
                $this->saveImage($image, $incidence->id);
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
     * @return string
     */

    public function getB64Extension(string $base64Image, $full=null): string
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
        $img =$this->getB64Image($base64Image);

        $imgExtension = $this->getB64Extension($base64Image);
        $imageName = 'incidence_image' .uniqid(). time() . '.' . $imgExtension;
        Storage::disk('local')->put(Incidence::IMAGE_PATH.$imageName, $img);
        $image = new IncidenceImage();
        $image->image = $imageName;
        $image->incidence_id = $id;

        $image->save();
    }

    /**
     * Export incidence
     * @return JsonResponse
     *
     */
    public function export():JsonResponse
    {
        $json_data = IncidenceResource::export();

        return response()->json([
            'status' => 'ok',
            'incidences' => $json_data
        ]);
    }

    public function getFormData(): JsonResponse
    {
        $workers = User::whereHas('userRole', function ($query){
            $query->where('name','=','Trabajador');
        })->get();
        return response()->json(
            [
                'areas' => AreaResource::collection(Area::all()),
                'states' => StateResource::collection(State::all()),
                'tags' => TagResource::collection(Tag::all()),
                'priorities' => PriorityResource::collection(Priority::all()),
                'equipments' => EquipmentResource::collection(Equipment::all()),
                'public_centers' => PublicCenterResource::collection(PublicCenter::all()),
                'enrolments' => EnrolmentResource::collection(Area::all()),
                'streets' => StateResource::collection(Street::all()),
                'neighborhoods' => NeighborhoodResource::collection(Neighborhood::all()),
                'workers' => UserResource::forList($workers)
            ]
        );
    }

    public function removeImage($id): JsonResponse
    {
        $image = IncidenceImage::findOrFail($id);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => __('general.image_deleted')
        ]);
    }
}
