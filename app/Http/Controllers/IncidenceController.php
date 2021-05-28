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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class IncidenceController extends Controller
{
    /**
     * Get data of all Incidences
     *
     * @return array
     */
    public function index(): array
    {
        return Incidence::all();
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
     * Get data of a Incidence
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $incidence=Incidence::find($id);

        return response()->json($incidence, 200) ;
    }

    /**
     * create a new Incidence
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $incidence = Incidence::create($request->all());

        return response()->json($incidence, 200);
    }

    /**
     * update a  Incidence
     *@param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $parameters = $request->only(
            'name',
            'assignedTo',
            'reviewer',
            'deadLine',
            'creationDate',
            'tags',
            'description',
            'attachedContentn',
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
            return response()->json("This incidence is not exist", '401');
        }

        $incidence->name = $parameters['name'];
        $incidence->assignedTo = $parameters['assignedTo'];
        $incidence->reviewer = $parameters['reviewer'];
        $incidence->deadLine = $parameters['deadLine'];
        $incidence->creationDate = $parameters['creationDate'];
        $incidence->tags = $parameters['tags'];
        $incidence->description = $parameters['description'];
        $incidence->attachedContentn = $parameters['attachedContentn'];
        $incidence->dni = $parameters['dni'];
        $incidence->applicant = $parameters['applicant'];
        $incidence->phone = $parameters['phone'];
        $incidence->centerEnrollment = $parameters['centerEnrollment'];
        $incidence->streetNumber = $parameters['streetNumber'];
        $incidence->district = $parameters['district'];
        $incidence->neighborhood = $parameters['neighborhood'];
        $incidence->addressee = $parameters['addressee'];
        $incidence->team = $parameters['team'];
        $incidence->location = $parameters['location'];
        $incidence->responseForCitizen = $parameters['responseForCitizen'];
        $incidence->idState = $parameters['idState'];
        $incidence->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete a Incidence
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $incidence = Incidence::find($id);

        if (!$incidence) {
            return response()->json("This incidence is not exist", '401');
        }

        Incidence::destroy($id);
        return  response()->json('deleted', 200);
    }


    /**
     * Create a Galery for the Incidences
     *
     * @param $id
     * @param Request request
     * @return void
     */
    public function createGaleryIncidence(Request $request, $id): void
    {
        $image=new IncidenceImage();
        $incidenceImage=$request->file('img');
        $route = public_path().'/galery_incidence/';
        $imageName=$incidenceImage->getClientOriginalName();
        $incidenceImage->move($route, $imageName);
        $image->image=$imageName;
        $image->idIncidence=$id;
        $image->save();
    }
}
