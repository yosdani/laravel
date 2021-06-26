<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;
use App\RoleUser;
use App\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Shows user info
     * @return UserResource *
     *  * @OA\Get (
     *      path="/user-info",
     *      tags={"Auth"},
     *      summary="Shows user info",
     *      description="Returns authenticated user information",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
    public function getUserInfo(): UserResource
    {
        if(!JWTAuth::parseToken()->authenticate()){
            throw new UnauthorizedException();
        }
        return new UserResource(JWTAuth::parseToken()->authenticate());
    }
}
