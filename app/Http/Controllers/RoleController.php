<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Role;


class RoleController extends Controller
{
    
    /**
     * List of roles
     * @OA\Get(
     *      path="/roles",
     *      tags={"Roles"},
     *      summary="Get list of roles",
     *      description="Returns list of roles",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation")
     *       )
     *     )
     */
    public function index()
    {
        //get all roles
        $roles = Role::all();

        //return all roles
        return response() -> json($roles, 200);
    }

    /**
     * Get role by id
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get (
     *      path="/roles/{id}",
     *      tags={"Roles"},
     *      summary="Get a role by id",
     *      description="Returns the role",
     *     @OA\Parameter(
     *          name="id",
     *          description="Role id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="The role not be found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        //Validate that id exist
        if (Role::find($id)) {
            //return role
            return response() -> json(Role::find($id), 201);
        } else {
            //return when no found the id
            return response() -> json(404);
        }
    }

    /**
     * Create a new role
     * @param Request $request
     * @return JsonResponse
     *  * @OA\Post (
     *      path="/roles",
     *      tags={"Roles"},
     *      summary="Create a new role",
     *      description="Returns created role",
     *     @OA\Parameter(
     *          name="request",
     *          description="request all datas",
     *          required=true,
     *          in="path",
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function store(Request $request): JsonResponse
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
     * @OA\Put(
     *      path="/roles/{id}",
     *      tags={"Roles"},
     *      summary="Update a role",
     *      description="Returns updated role",
     *     @OA\Parameter(
     *          name="id",
     *          description="role id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function update(Request $request, int $id): JsonResponse
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
            return response()->json($role, 201);
        } else {
            //return when no found the id
            return response()->json(400);
        }
    }

    /**
     * Delete the existing role
     * @param int $id
     * @return JsonResponse
     * @OA\Delete  (
     *      path="/roles/{id}",
     *      tags={"Roles"},
     *      summary="Delete a role",
     *      description="Returns Json response",
     *     @OA\Parameter(
     *          name="id",
     *          description="Role id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function delete(int $id): JsonResponse
    {
        //Validate the id exist
        if (Role::find($id)) {
            //get the role by id
            $role = Role::find($id);

            //Delete the role
            $role->delete();

            //return the status
            return response()->json(201);
        } else {
            //return when no found the id
            return response()->json(400);
        }
    }
}
