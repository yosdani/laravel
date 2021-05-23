<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/20/2021
 * Time: 7:28 AM
 */

namespace App\Http\Controllers;


use App\Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    public function index()
    {
        $area = Area::all();
        return $area;
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
     * Get data of a Area
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area=Area::find($id);

        return response()->json($area,200) ;
    }

    /**
     * create a new Area
     * @param Request $request
     *
     * @return Area
     */
    public function store(Request $request)
    {
        $area = Area::create($request->all());

        return response()->json($area, 200);
    }

    /**
     * update a  Area
     *@param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    function update( Request $request,$id)
    {
        $parameters = $request->only('name');

        $area = Area::find($id);
        $area->name = $parameters['name'];

        $area->save();

        return response()->json('updated',200);
    }

    /**
     * Delete a Area
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Area::destroy($id);

        return  response()->json('deleted',200);
    }
}