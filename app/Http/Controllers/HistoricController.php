<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Http\Resources\HistoricResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    /**
     * List of historic
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $value = '-';
        $data = Historic::paginate(15);
        $historic = HistoricResource::collection($data)->response()->getData(true);
        return response()->json([
            'success' =>true,
            'historic' => $historic
        ], 200);
    }

    /**
     * Get historic by id
     *
     * @param int $id
     * @return JsonResponse
     *
     *
     */
    public function show($id):JsonResponse
    {
        $historic = Historic::findOrFail($id);
        return response()->json([
            'success'=>true,
            'historic'=> new HistoricResource($historic)
        ], 200);
    }

}
