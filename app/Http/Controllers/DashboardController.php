<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Area;
use App\Incidence;
use App\District;
use App\User;

class DashboardController extends Controller
{
    /**
     * Get all information about bar graphic
     * @return JsonResponse
     * 
     * 
     */
    public function bar():JsonResponse
    {
        $areas = Area::information();

        $totalIncidences = [];
        $totalIncidencesFinished = [];
        $totalIncidencesInProgress = [];
        $totalIncidencesUnsigned = [];
        $names = [];

        foreach ($areas as $area){
            $totalIncidences [] = Incidence::incidencesTotalByArea( $area->user_id );

            $totalIncidencesFinished [] = Incidence::stateActual( $area->user_id, 2);

            $totalIncidencesInProgress [] = Incidence::stateActual( $area->user_id, 1);

            $totalIncidencesUnsigned [] = Incidence::stateActual( $area->user_id, null);
        }

        foreach(Area::names() as $name) {
            $names[]= $name->name;
        }

        return response()->json([
            'areas' => $names,
            'totalByAreas' => $totalIncidences,
            'totalFinish' => $totalIncidencesFinished,
            'totalInProgress' => $totalIncidencesInProgress,
            'totalUnsigned' => $totalIncidencesUnsigned
        ], 200);
    }

    /**
     * Get all information about radar graphic
     * @return JsonResponse
     * 
     */
    public function radar():JsonResponse
    {
        $district = District::information();

        $incidenceByDistrict = [];

        foreach ($district as $dist){
            $incidenceByDistrict [] = Incidence::getIncidenceByDistrict( $dist->id );
        }

        $names = [];

        foreach(District::names() as $name) {
            $names[]= $name->district;
        }

        return response()->json([
            'districts' => $names,
            'incidences' => $incidenceByDistrict
        ]);
    }

    /**
     * Get teams of work, responsable and workers
     * @return JsonResponse
     * 
     */
    public function teams():JsonResponse
    {
        $areas = Area::information();

        $workersByArea = [];
        $responsablesByArea = [];

        foreach ($areas as $area){
            $workers [] = [
                'total' => Incidence::where('reviewer','=',Area::where('id','=',$area->id)->with('user')->first()->id)->count(),
                'response' => Area::where('id','=',$area->id)->with('user')->first(),
                'workers' => User::workersByArea( $area->id )
            ];
        }


        return response()->json([
            'workers' => $workers
        ]);
    }
}
