<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Participación Ciudadana Documentación API",
 *      description="Endpoints de la app Participación Ciudadana",
 *      @OA\Contact(
 *          email="ciudadana@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Endpoints de la app Participación Ciudadana"
 * )

 *
 * @OA\Tag(
 *     name="Participación Ciudadana",
 *     description="Endpoints de la app Participación Ciudadana"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Save the filters of user authenticate
     * @param string $period
     * @param Carbon $dateInit
     * @param Carbon $dateEnd
     * @param array $tags
     * @param array $states
     *
     * @return void
     *
     */
    public function saveFilters( $period, $dateInit, $dateEnd, $tags, $states):void
    {
        $new_filters = json_encode([
            'period' => $period,
            'dateInit' => $dateInit,
            'dateEnd' => $dateEnd,
            'tags' => $tags,
            'states' => $states
        ]);

        auth()->user()->filters = $new_filters;
        auth()->user()->save();
    }

    /**
     * Get date by period
     * @param string $period
     * @param Carbon $dateEnd
     * @return Carbon
     */
    public function typeDateFilter($dateEnd, $type):Carbon
    {
        switch ($type) {
        case 'year': {
            $dateInit = new Carbon($dateEnd);
            return $dateInit->subYear()->startOfDay();
            }
        case 'month': {
            $dateInit = new Carbon($dateEnd);
            return $dateInit->subMonth()->startOfDay();
            }
        case 'week': {
            $dateInit = new Carbon($dateEnd);
            return $dateInit->subWeek()->startOfDay();
            }
        case 'day': {
            $dateInit = new Carbon($dateEnd);
            return $dateInit->startOfDay();
            }
        }
    }
}
