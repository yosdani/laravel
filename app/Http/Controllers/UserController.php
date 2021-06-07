<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;
use App\RoleUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
            'success' => true,
            'users' => User::select('users.name', 'users.email', 'users.phoneNumber')->paginate(15)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse
    {
        //create a new user
        $user = new User();

        //get the dates of requests
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;

        //bcrypt the password hashed
        $user->password = bcrypt($request->password);

        //register the user
        $user->save();

        $role_user = new RoleUser();

        if ($request->role) {
            $role = Role::where('name', '=', $request->role)->first();
            $role_user->user_id = $user->id;
            $role_user->role_id = $role->id;

            $role_user->save();
        } else {
            $role_user->role_id = 2;
            $role_user->user_id = $user->id;
            $role_user->save();
        }
        //return the user
        return response()->json([
             'success' => true,
            'user' => $user
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id):JsonResponse
    {
        if (!$user = User::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'user' => $user
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit(int $id): JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id):JsonResponse
    {
        if (!$user = User::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        $user->update($request->all());
        $role_user = RoleUser::where(['user_id'=>$user->id])->get();

        return response()->json([
            'success' =>true,
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id):JsonResponse
    {
        if (!User::find($id)) {
            return response()->json([
                'success'=>false,
                'message'=>'The specified id does not exist'
            ], 400);
        }

        User::destroy($id);

        return response()->json([
            'success' =>true,
            'message' =>'The user was successfully deleted'
        ]);
    }
}
