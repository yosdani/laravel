<?php

namespace App\Http\Controllers;

use App\Breakdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BreakdownController extends Controller
{
    /**
     * Get data of all Types of Breakdown
     *
     * @return array
     */
    public function index()
    {
        return Breakdown::all();
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
     * Get data of an Breakdown
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function show(int $id): JsonResponse
    {
        $breakdown=Breakdown::find($id);

        return response()->json($breakdown, 200) ;
    }

    /**
     * create a new Breakdown
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function store(Request $request): JsonResponse
    {
        $breakdown = Breakdown::create($request->all());

        return response()->json($breakdown, 200);
    }

    /**
     * Update an  Breakdown
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     *
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $parameters = $request->only('name');

        $breakdown = Breakdown::find($id);
        $breakdown->name = $parameters['name'];

        $breakdown->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete a Breakdown
     *
     */
    public function destroy(int $id): JsonResponse
    {
        Breakdown::destroy($id);

        return  response()->json('deleted', 200);
    }
}
