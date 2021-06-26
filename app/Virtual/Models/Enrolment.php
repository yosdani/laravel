<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Enrolment",
 *     description="Enrolment model",
 *     @OA\Xml(
 *         name="Enrolment"
 *     )
 * )
 */
class Enrolment
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
     *      description="Name of the new Enrolment",
     *      example="Vsd23"
     * )
     *
     * @var string
     */
    public $name;
}
