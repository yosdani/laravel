<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="PublicCenter",
 *     description="PublicCenter model",
 *     @OA\Xml(
 *         name="PublicCenter"
 *     )
 * )
 */
class PublicCenter
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
     *      example="Town center"
     * )
     *
     * @var string
     */
    public $name;
}
