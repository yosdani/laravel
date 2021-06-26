<?php


namespace App\Virtual\Models;

use App\Virtual\Resources\NewsImageResource;

/**
 * @OA\Schema(
 *     title="News",
 *     description="News model",
 *     @OA\Xml(
 *         name="News"
 *     )
 * )
 */
class News
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
     *      title="Title",
     *      description="Title of the new News",
     *      example="A perfect weather today"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Sub title",
     *      description="Sub title of the new News",
     *      example="The best day"
     * )
     *
     * @var string
     */
    public $subtitle;

    /**
     * @OA\Property(
     *      title="Content",
     *      description="Content of the new incidence",
     *      example="Lorem ipsum dolor..."
     * )
     *
     * @var string
     */
    public $content;

    /**
     * @OA\Property(
     *       title="User",
     *       description="User who create the News"
     * )
     *
     * @var  User
     */
    public $author;

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID of the related category",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $category_id;

    /**
     * @OA\Property(
     *      title="Category name",
     *      description="Name of the related Category",
     *      example="Sports"
     * )
     *
     * @var string
     */
    public $category_name;

    /**
     * @OA\Property(
     *      title="Images",
     *      description="Array of images",
     *
     * )
     *
     * @var  NewsImage[]
     */
    public $images;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updatedAt;
}
