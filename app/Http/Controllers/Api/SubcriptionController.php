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

    public function subcribe($categoryId,$userId)
    {

        $userCategory=new UserCategory();
        $userCategory->user_id=$userId;
        $userCategory->category_id=$categoryId;


        $userCategory->save();

        return $userCategory;
    }
}