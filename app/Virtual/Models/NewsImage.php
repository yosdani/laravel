<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="NewsImage",
 *     description="NewsImage model",
 *     @OA\Xml(
 *         name="NewsImage"
 *     )
 * )
 */
class NewsImage
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
     *      title="Incidence Id",
     *      description="Id of the related News",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $news_id;

    /**
     * @OA\Property(
     *      title="Url",
     *      description="Url of the image",
     *      example="https://ciudadana/api/v1/image/news/example.jpg"
     * )
     *
     * @var string
     */
    public $url;

}
