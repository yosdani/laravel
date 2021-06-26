<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Category",
 *     description="News Category",
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the new State",
     *      example="District 1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Subscribed",
     *      description="Indicates if a user is subscribed to this category for Notifications",
     *      example="1"
     * )
     *
     * @var boolean
     */
    public $subscribed;

    /**
     * @OA\Property(
     *      title="News",
     *      description="Array of related News",
     *
     * )
     *
     * @var  News[]
     */
    public $news;
}
