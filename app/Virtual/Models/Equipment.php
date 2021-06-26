<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Equipment",
 *     description="Equipment model",
 *     @OA\Xml(
 *         name="Equipment"
 *     )
 * )
 */
class Equipment
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
     *      description="Name of the new Equipment",
     *      example="Public Telephone"
     * )
     *
     * @var string
     */
    public $name;
}
