<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    //Get list of roles
    public function getRoles()
    {
        //get all roles
        $roles = Role::all();

        //return all roles
        return response() -> json($roles, 200);
    }

    //Get role by id
    public function getRoleById($id): JsonResponse
    {
        //Validate that id exist
        if (Role::find($id)) {
            //return role
            return response() -> json(Role::find($id), 200);
        } else {
            //return when no found the id
            return response() -> json(404);
        }
    }

    /**
     * Create a new role
     * @param Request $request
     * @return JsonResponse
     */
    public function createRole(Request $request): JsonResponse
    {
        //create a new role
        $newRole = new Role();

        //get the name of the new role
        $newRole ->name = $request->name;

        //save the new role
        $newRole ->save();

        //return the new role JSON
        return response()->json($newRole, 201);
    }

    /**
     * Update the existing role by id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateRole(Request $request, int $id): JsonResponse
    {
        //Validate that id exist
        if (Role::find($id)) {
            //get the role by id
            $role = Role::find($id);

            //Change the data of the role
            $role->name = $request->name;

            //save the role update
            $role->save();

            //return the role updated JSON
            return response()->json($role, 200);
        } else {
            //return when no found the id
            return response()->json(404);
        }
    }

    /**
     * Delete the existing role
     * @param int $id
     * @return JsonResponse
     */
    public function deleteRole(int $id): JsonResponse
    {
        //Validate the id exist
        if (Role::find($id)) {
            //get the role by id
            $role = Role::find($id);

            //Delete the role
            $role->delete();

            //return the status
            return response()->json(204);
        } else {
            //return when no found the id
            return response()->json(404);
        }
    }
}
