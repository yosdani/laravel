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
use App\Http\Resources\AreaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\WorkerArea;
use App\User;

class AreaController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $areas = [];
        if($user->hasRole('Admin')){
            $areas = Area::paginate(15);
        }elseif ($user->hasRole('Responsable')){
            $areas = Area::where('user_id',$user->id)->paginate(15);
        }

        return response()->json([
            'success' =>true,
            'areas' =>  Area::paginate(15)
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
        $area=Area::where('id','=',$id)->with('user')->first();

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
        $area->user_id = $request->user_id;
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

    /**
     * Add workers to area
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function addWorker(Request $request,$id): JsonResponse
    {
        if(!Area::find($id)){
            return response()->json([
                'success' => false,
                'message' =>'The specified id of area is not found'
            ], 404);
        }

        $workerId = $request->id;

        WorkerArea::create([
            'user_id' => $workerId,
            'area_id' => $id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Workers add successfully'
        ]);
    }

    /**
     * Get workers of area
     * @param int $idArea
     * @return JsonResponse
     * 
     */
    public function getWorkers($idArea): JsonResponse
    {
        if( !Area::find($idArea) ){
            return response()->json([
                'success' => false,
                'message' => 'The specified id does not exist'
            ]);
        }

        return response()->json([
            'success' => true,
            'workers' => Area::where('id', '=',$idArea)->with('workers')->first()
        ]);
    }

    /**
     * Delete worker of area
     * @param int $idWorker
     * @return JsonResponse
     * 
     * 
     */
    public function deleteWorker($idWorker): JsonResponse
    {
        if(!WorkerArea::where( 'user_id', '=', $idWorker)->first()){
            return response()->json([
                'success' => false,
                'message' => 'The specified id does not exist'
            ]);
        }

        $workerArea = WorkerArea::where( 'user_id', '=', $idWorker)->first();
        $workerArea->delete();

        return response()->json([
            'success' => true,
            'message' => 'The specified was successfully deleted'
        ]);
    }
}
