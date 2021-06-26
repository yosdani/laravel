<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="District",
 *     description="District model",
 *     @OA\Xml(
 *         name="District"
 *     )
 * )
 */
class District
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
}
