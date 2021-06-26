<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="State",
 *     description="State model",
 *     @OA\Xml(
 *         name="State"
 *     )
 * )
 */
class State
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
     *      example="Finished"
     * )
     *
     * @var string
     */
    public $name;
}
