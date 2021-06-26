<?php


namespace App\Virtual;

/**
 * @OA\Schema(
 *      title="Store Incidence request",
 *      description="Store Incidence request body data",
 *      type="object",
 *      required={"title","description","location"}
 * )
 */
class StoreIncidenceRequest
{
    /**
     * @OA\Property(
     *      title="Title",
     *      description="Title of the new incidence",
     *      example="A broken wall"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new incidence",
     *      example="This wall is broken"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="Location",
     *      description="Location coordinates in Json format, lat, lng",
     *      example="{lat: 545455, lng: 445422}"
     * )
     *
     * @var string
     */
    public $location;

    /**
     * @OA\Property(
     *      title="Images",
     *      description="Array of images in base64 format",
     *      example=""
     * )
     *
     * @var string
     */
    public $img;
}
