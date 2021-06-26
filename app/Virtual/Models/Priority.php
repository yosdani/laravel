<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Priority",
 *     description="Priority model",
 *     @OA\Xml(
 *         name="Priority"
 *     )
 * )
 */
class Priority
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
     *      example="High"
     * )
     *
     * @var string
     */
    public $name;
}
