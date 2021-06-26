<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Neighborhood",
 *     description="Neighborhood model",
 *     @OA\Xml(
 *         name="Neighborhood"
 *     )
 * )
 */
class Neighborhood
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
     *      example="Center"
     * )
     *
     * @var string
     */
    public $name;
}
