<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\userRoles;

class UserRolesController extends Controller
{
    //Get list of roles
    public function getRoles(){
        //get all roles
        $roles = userRoles::all();

        //return all roles
        return response() -> json( $roles, 200 );
    }

    //Get role by id
    public function getRoleById( $id ){
        //Validate that id exist
        if( userRoles::find( $id ) ){
            //return role
            return response() -> json( userRoles::find( $id ), 200 );
        }else{
            //return when no found the id
            return response() -> json( 404 );
        }
    }

    //Create a new role
    public function createRole( Request $request){
        //create a new role
        $newRole = new userRoles();

        //get the name of the new role
        $newRole -> name = $request -> name;

        //save the new role
        $newRole -> save();

        //return the new role JSON
        return response() -> json( $newRole, 201 );
    }

    //update the existing role by id
    public function updateRole( Request $request, $id){
        //Validate that id exist
        if( userRoles::find( $id ) ){
            //get the role by id
            $role = userRoles::find( $id );

            //Change the data of the role
            $role -> name = $request -> name;

            //save the role update
            $role -> save();

            //return the role updated JSON
            return response() -> json( $role, 200 );
        }else{
            //return when no found the id
            return response() -> json( 404 );
        }
    }

    //delete the existing role
    public function deleteRole( $id ){
        //Validate the id exist
        if( userRoles::find( $id ) ){
            //get the role by id
            $role = userRoles::find( $id );

            //Delete the role
            $role -> delete();

            //return the status
            return response() -> json( 204 );
        }else{
            //return when no found the id
            return response() -> json( 404 );
        }
    }
}
