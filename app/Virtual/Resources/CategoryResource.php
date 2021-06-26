<?php


namespace App\Virtual\Resources;

use App\Virtual\Models\Category;
use App\Virtual\Models\Incidence;

/**
 * @OA\Schema(
 *     title="CategoryResource",
 *     description="Category resource",
 *     @OA\Xml(
 *         name="CategoryResource"
 *     )
 * )
 */
class CategoryResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Category[]
     */
    private $data;
}
