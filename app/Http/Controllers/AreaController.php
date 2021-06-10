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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' =>true,
            'incidences' => Area::paginate(15)
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
     * Get area by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * 
     */
    public function show(int $id): JsonResponse
    {
        $area=Area::find($id);

        if (!$area) {
            return response()->json("This area is not exist", '404');
        }

        return response()->json($area, 200) ;
    }

    /**
     * Create a new Area
     * @param Request $request
     * @return JsonResponse
     * 
     */
    public function store(Request $request): JsonResponse
    {
        $area = Area::create($request->all());

        return response()->json($area, 200);
    }

    /**
     * Update the existing area by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * 
     */
    public function update(Request $request, int $id): JsonResponse
    {

        $area = Area::find($id);
        if (!$area) {
            return response()->json("This area is not exist", '400');
        }
        $area->name = $request->name;

        $area->save();
        return response()->json([
            'area'=>$area,
            'success' => true,
            'message' => 'The area has been updated successfully'
        ], 200);




    }

    /**
     * Delete the existing area
     * @param int $id
     * @return JsonResponse
     * 
     */
    public function destroy(int $id): JsonResponse
    {
        $area = Area::find($id);

        if (!$area) {
            return response()->json("This area is not exist", '400');
        }
        Area::destroy($id);

        return  response()->json('deleted', 200);
    }
}
