<?php

namespace App\Http\Controllers;

use App\Breakdown;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BreakdownController extends Controller
{
    /**
     * List of breakdowns
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' =>true,
            'breakdowns' => Breakdown::paginate(15)
        ], 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data): Validator
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',

        ]);
    }

    /**
     * Get breakdown by id
     *
     * @param int $id
     * @return JsonResponse
     *
     *
     */
    public function show(int $id)
    {
        $breakdown=Breakdown::find($id);

        if (!$breakdown) {
            return response()->json("This breakdown is not exist", '404');
        }
        return response()->json($breakdown, 200) ;
    }

    /**
     * Create a new Breakdown
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function store(Request $request)
    {
        $breakdown = Breakdown::create($request->all());


        return response()->json($breakdown, 200);
    }

    /**
     * Update the existing breakdown by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     *
     */
    public function update(Request $request, int $id)
    {
        $parameters = $request->only('name');

        $breakdown = Breakdown::find($id);

        if (!$breakdown) {
            return response()->json("This breakdown is not exist", '400');
        }
        $breakdown->name = $parameters['name'];

        $breakdown->save();

        return response()->json(['updated', 200]);
    }

    /**
     * Delete the existing breakdown
     * @param int $id
     * @return JsonResponse
     *
     */
    public function destroy(int $id)
    {
        $breakdown = Breakdown::find($id);

        if (!$breakdown) {
            return response()->json("This breakdown is not exist", '400');
        }
        Breakdown::destroy($id);

        return  response()->json('The breakdown was successfully deleted', 200);
    }
}
