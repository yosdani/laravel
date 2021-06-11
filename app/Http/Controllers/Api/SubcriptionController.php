<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/9/2021
 * Time: 10:01 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\UserCategory;
use App\Category;

class SubcriptionController extends Controller
{

    /**
     * create new subscription
     * @return JsonResponse
     */
    public function toSubscribe(Request $request)
    {
        foreach ($request->categories as $category) {


            $userCategory = new UserCategory();
            $userCategory->user_id = JWTAuth::parseToken()->authenticate()->id;
            $userCategory->category_id = $category;


            $userCategory->save();

        }
        $categories=User::where('id',$userCategory->user_id)->with('userCategory')->get();

        return response()->json($categories, 201);

    }
}