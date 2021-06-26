<?php


namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
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
     *      description="Name of the new User",
     *      example="John"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="last Name",
     *      description="Last Name of the new User",
     *      example="Doe"
     * )
     *
     * @var string
     */
    public $lastName;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Email of the new User",
     *      example="john@domain.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="Phone Number",
     *      description="Phone Number of the new User",
     *      example="234 545 567"
     * )
     *
     * @var string
     */
    public $phoneNumber;

    /**
     * @OA\Property(
     *      title="Allow Notifications sounds",
     *      description="Indicates if a User wants to be nofied with sound in Push Notifications",
     *      example="1"
     * )
     *
     * @var boolean
     */
    public $allow_notify;
}
