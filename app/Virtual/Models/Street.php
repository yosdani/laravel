<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Street",
 *     description="Street model",
 *     @OA\Xml(
 *         name="Street"
 *     )
 * )
 */
class Street
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
     *      title="Street name",
     *      description="Name of the new State",
     *      example="4th avenue"
     * )
     *
     * @var string
     */
    public $street;

}
