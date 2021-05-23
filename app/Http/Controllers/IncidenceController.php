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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class IncidenceController extends Controller
{
    /**
     * Get data of all Incidences
     *
     * @return array
     */
    public function index()
    {
        $incidence = Incidence::all();
        return $incidence;
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

        ]);
    }

    /**
     * Get data of a Incidence
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $incidence=Incidence::find($id);

        return response()->json($incidence,200) ;
    }

    /**
     * create a new Incidence
     * @param Request $request
     *
     * @return Incidence
     */
    public function store(Request $request)
    {
        $incidence=new Incidence();
        $imageIncidence=$request->file('img');
        $route = public_path().'/uploads/';
        $imageName=$imageIncidence->getClientOriginalName();
        $imageIncidence->move($route,$imageName);
        $incidence->name= $request->name;
        $incidence->assignedTo = $request->assignedTo;
        $incidence->reviewer=$request->reviewer;
        $incidence->deadLine=$request->deadLine;
        $incidence->creationDate=$request->creationDate;
        $incidence->tags=$request->tags;
        $incidence->description=$request->description;
        $incidence->attachedContentn=$request->attachedContentn;
        $incidence->dni=$request->dni;
        $incidence->applicant=$request->applicant;
        $incidence->phone=$request->phone;
        $incidence->centerEnrollment=$request->centerEnrollment;
        $incidence->streetNumber=$request->streetNumber;
        $incidence->district=$request->district;
        $incidence->neighborhood=$request->neighborhood;
        $incidence->addressee=$request->addressee;
        $incidence->team=$request->team;
        $incidence->location=$request->location;
        $incidence->responseForCitizen=$request->responseForCitizen;
        $incidence->idUser=$request->idUser;
        $incidence->idState=$request->idState;
        $incidence->image=$imageName;
        $incidence->save();
        return response()->json($incidence, 200);
    }

    /**
     * update a  Incidence
     *@param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    function update( Request $request,$id)
    {
        $parameters = $request->only('name','assignedTo','reviewer','deadLine','creationDate','tags',
            'description','attachedContentn','dni','applicant','phone','centerEnrollment','streetNumber',
            'district','neighborhood','addressee','team','location','responseForCitizen','idState');

        $incidence = Incidence::find($id);
        if(!$incidence){
            return response()->json("This incidence is not exist",'401');
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

        return response()->json('updated',200);
    }

    /**
     * Delete a Incidence
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $incidence = Incidence::find($id);

        if(!$incidence){
            return response()->json("This incidence is not exist",'401');
        }

        Incidence::destroy($id);
        return  response()->json('deleted',200);
    }
}