<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\State;

class StateController extends Controller
{

    /**
     *@return JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' =>true,
            'states' => State::select('states.*')->paginate(15)
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
     * Get state by id
     *
     * @param int $id
     * @return JsonResponse
     *
     */
    public function show(int $id): JsonResponse
    {
        $state=State::find($id);
        if (!$state) {
            return response()->json("This state is not exist", '400');
        }
        return response()->json($state, 200) ;
    }

    /**
     * Create a new State
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $state = State::create($request->all());

        return response()->json($state, 200);
    }

    /**
     * Update the existing state by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $parameters = $request->only('name');

        $state = State::find($id);
        if (!$state) {
            return response()->json("This state is not exist", '400');
        }
        $state->name = $parameters['name'];

        $state->save();

        return response()->json('updated', 200);
    }

    /**
     * Delete the existing state
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $state = State::find($id);

        if (!$state) {
            return response()->json("This state is not exist", '400');
        }

        State::destroy($id);

        return  response()->json('deleted', 200);
    }
}
