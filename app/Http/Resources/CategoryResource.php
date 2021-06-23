<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'news' => NewsResource::collection($this->news)
        ];
    }

    public static function categoryList($categories): array
    {
        $results = [];
        foreach ($categories as $category){
            $subscription= DB::table('user_categories')->where('category_id',$category->id)
                ->where('user_id',JWTAuth::parseToken()->authenticate()->id)
                ->first();
           $subscribed = null !== $subscription;
            $results[] = [
                'id' => $category->id,
                'name' => $category->name,
                'news' => NewsResource::collection($category->news),
                'subscribed' => $subscribed
            ];
        }

        return $results;
    }

}
