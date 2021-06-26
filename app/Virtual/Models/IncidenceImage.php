<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="IncidenceImage",
 *     description="IncidenceImage model",
 *     @OA\Xml(
 *         name="IncidenceImage"
 *     )
 * )
 */
class IncidenceImage
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
     *      description="Id of the related Incidence",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $incidence_id;

    /**
     * @OA\Property(
     *      title="Url",
     *      description="Url of the image",
     *      example="https://ciudadana/api/v1/image/incidences/example.jpg"
     * )
     *
     * @var string
     */
    public $url;

}
