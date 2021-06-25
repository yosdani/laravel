<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Area;
use App\Incidence;
use App\District;
use App\User;
use Carbon\Carbon;
use App\Tag;
use App\State;

class DashboardController extends Controller
{
    /**
     * Get all information about bar graphic
     * @param $filters
     * @return array
     *
     *
     */
    public function bar( $filters ):array
    {

        $areas = Area::information( $filters['dateInit'], $filters['dateEnd'] );

        $totalIncidences = [];
        $totalIncidencesFinished = [];
        $totalIncidencesInProgress = [];
        $totalIncidencesUnsigned = [];
        $names = [];

        foreach ($areas as $area){
            $totalIncidences [] = Incidence::incidencesTotalByArea( $area->id, $filters['dateInit'], $filters['dateEnd'],$filters['tags'] );

            $totalIncidencesFinished [] = Incidence::stateActual( $area->id, 2, $filters['dateInit'], $filters['dateEnd'],$filters['tags']);

            $totalIncidencesInProgress [] = Incidence::stateActual( $area->id, 1, $filters['dateInit'], $filters['dateEnd'],$filters['tags']);

            $totalIncidencesUnsigned [] = Incidence::stateActual( $area->id, null, $filters['dateInit'], $filters['dateEnd'],$filters['tags']);
        }

        foreach(Area::names( $filters['dateInit'], $filters['dateEnd'] ) as $name) {
            $names[]= $name->name;
        }

        return [
            'areas' => $names,
            'totalByAreas' => $totalIncidences,
            'totalFinish' => $totalIncidencesFinished,
            'totalInProgress' => $totalIncidencesInProgress,
            'totalUnsigned' => $totalIncidencesUnsigned
        ];
    }

    /**
     * Get all information about radar graphic
     * @param  $filters
     * @return array
     *
     */
    public function radar( $filters ):array
    {

        $district = District::information( $filters['dateInit'], $filters['dateEnd'] );

        $incidenceByDistrict = [];

        foreach ($district as $dist){
            $incidenceByDistrict [] = Incidence::getIncidenceByDistrict( $dist->id, $filters['dateInit'], $filters['dateEnd'],$filters['tags'], $filters['states'] );
        }

        $names = [];

        foreach(District::names( $filters['dateInit'], $filters['dateEnd'] ) as $name) {
            $names[]= $name->district;
        }

        return [
            'districts' => $names,
            'incidences' => $incidenceByDistrict
        ];
    }

    /**
     * Get teams of work, responsable and workers
     * @param $filters
     * @return array
     *
     */
    public function teams( $filters ):array
    {

        $areas = Area::information( $filters['dateInit'], $filters['dateEnd'] );

        $workers = [];

        foreach ($areas as $area){
            $workers [] = [
                'total' => Incidence::where('area_id','=',$area->id)->count(),
                'response' => Area::where('id','=',$area->id)->with('user')->first(),
                'workers' => User::workersByArea( $area->id )
            ];
        }


        return [
            'workers' => $workers
        ];
    }

    /**
     * Get general statistics
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function getStatistics( Request $request ):JsonResponse
    {
        $filters = $this->getFilters( $request );

        return response()->json([
            'total' => Incidence::allIncidence($filters['dateInit'], $filters['dateEnd']),
            'finished' => Incidence::finished( $filters['dateInit'], $filters['dateEnd'] ),
            'in_progress' => Incidence::inProgress( $filters['dateInit'], $filters['dateEnd'], $filters['tags'] ),
            'not_assigned' => Incidence::notAssigned( $filters['dateInit'], $filters['dateEnd'] ),
            'bar' => $this->bar( $filters ),
            'radar' => $this->radar( $filters ),
            'teams' => $this->teams( $filters ),
        ]);
    }

    /**
     * Get filters to all
     * @param Request $request
     * @return array
     *
     */
    private function getFilters( Request $request ): array
    {

        $period = $request->period;

        $this->saveFilters(
            $period,
            $request->dateInit,
            $request->dateEnd,
            $request->tags,
            $request->states
        );
        $filters = json_decode(auth()->user()->filters);

        if (null !== $filters->dateEnd)
            $filters->dateEnd = Carbon::now()->endOfDay();
            else {
                $filters->dateEnd = new Carbon($filters->dateEnd);
            }
            // If the initial date is undefined
        if (null !== $filters->dateInit) {
            $filters->dateInit = $this->typeDateFilter($filters->dateEnd, $filters->period);
            } else {
                $filters->dateInit = new Carbon($filters->dateInit);
            }

        if( $filters->tags == null){
            $filters->tags = Tag::allTags( $filters->dateInit, $filters->dateEnd);
        }

        if( $filters->states == null){
            $filters->states = State::allStates( $filters->dateInit, $filters->dateEnd);
        }

        return array(
            'dateInit' => $filters->dateInit,
            'dateEnd' => $filters->dateEnd,
            'tags' => $filters->tags,
            'states' => $filters->states
        );
    }
}
