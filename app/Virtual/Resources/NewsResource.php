<?php


namespace App\Virtual\Resources;

use App\Virtual\Models\Category;
use App\Virtual\Models\Incidence;

/**
 * @OA\Schema(
 *     title="NewsResource",
 *     description="News resource",
 *     @OA\Xml(
 *         name="NewsResource"
 *     )
 * )
 */
class NewsResource
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
