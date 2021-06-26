<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Area",
 *     description="Area model",
 *     @OA\Xml(
 *         name="Area"
 *     )
 * )
 */
class Area
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
     *      example="Maintenance"
     * )
     *
     * @var string
     */
    public $name;
}
