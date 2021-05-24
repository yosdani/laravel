<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 5/19/2021
 * Time: 9:39 AM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\State;

class StateController extends Controller
{
    public function index()
    {
        return State::all();
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
     * Get data of a state
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $state=State::find($id);

        return response()->json($state, 200) ;
    }

    /**
     * create a new State
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $state = State::create($request->all());

        return response()->json($state, 200);
    }

    /**
     * update a  State
     *@param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $parameters = $request->only('name');

        $state = State::find($id);
        $state->name = $parameters['name'];

        $state->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete a State
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $state = State::find($id);

        if (!$state) {
            return response()->json("This state is not exist", '401');
        }

        State::destroy($id);

        return  response()->json('deleted', 200);
    }
}
