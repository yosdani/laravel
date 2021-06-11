<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/9/2021
 * Time: 10:01 PM
 */

namespace App\Http\Controllers\Api;


use App\UserCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\DB;
;

class SubcriptionController extends Controller
{

    /**
     * create new subscription
     * @return JsonResponse
     */
    public function toSubscribe(Request $request)
    {
        foreach ($request->categories as $category) {

           $subscription= DB::table('user_categories')->where('category_id',$category)
               ->where('user_id',JWTAuth::parseToken()->authenticate()->id)
                ->first();

           if(!empty($subscription)){

               return response()->json("This subscription   exist", '404');
           }
            $userCategory = new UserCategory();
            $userCategory->user_id = JWTAuth::parseToken()->authenticate()->id;
            $userCategory->category_id = $category;


            $userCategory->save();

        }
        $categories=User::where('id',$userCategory->user_id)->with('userCategory')->get();

        return response()->json($categories, 201);

    }
}