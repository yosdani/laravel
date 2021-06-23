<?php
/**
 * Created by PhpStorm.
 * User: tabares
 * Date: 6/9/2021
 * Time: 10:01 PM
 */

namespace App\Http\Controllers\Api;


use App\Category;
use App\Http\Resources\CategoryResource;
use App\UserCategory;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\DB;


;

class SubscriptionController extends Controller
{

    /**
     * Create a new subscription
     * @param Request $request
     * @return JsonResponse
     *    @OA\Post (
     *        path="/subscription",
     *        tags={"Subscriptions"},
     *        summary="Update user's category subscriptions",
     *        description="Update subscriptions from an array of Category ids",
     *    @OA\RequestBody(
     *        required=true,
     *        description="Categories ids",
     *        @OA\JsonContent(
     *           required={"categories"},
     *           @OA\Property(property="categories", type="array", example="[1,2]",
     *               @OA\Items( type="array", @OA\Items())
     *           ),
     *        ),
     *
     *    ),
     *      @OA\Response(
     *          response=200,
     *          description="List of all categories with the subscribed field updated",
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
    public function toSubscribe(Request $request): JsonResponse
    {
        $userId = JWTAuth::parseToken()->authenticate()->id;
        $categoriesId = $request->categories;
        $userSubscription = DB::table('user_categories')
            ->where('user_id',$userId)->get();

        foreach ($userSubscription as $subscription){
           if (!in_array($subscription->category_id,$categoriesId)){
               DB::table('user_categories')->where('category_id',$subscription->category_id)
                   ->where('user_id',$userId)->delete();
           }
        }

        foreach ($categoriesId as $categoryId){
            $subscription = DB::table('user_categories')->where('category_id',$categoryId)
                ->where('user_id',$userId)->first();
            if(!$subscription){
                $userCategory = new UserCategory();
                $userCategory->user_id = $userId;
                $userCategory->category_id = $categoryId;

                $userCategory->save();
            }
        }

        return response()->json(CategoryResource::categoryList(Category::all()), 200);

    }

}
