<?php


namespace App\Virtual\Models;

use App\Virtual\Resources\IncidenceImageResource;

/**
 * @OA\Schema(
 *     title="Incidence",
 *     description="Incidence model",
 *     @OA\Xml(
 *         name="Incidence"
 *     )
 * )
 */
class Incidence
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
     *      title="Title",
     *      description="Title of the new incidence",
     *      example="A broken wall"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new incidence",
     *      example="This wall is broken"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="Internal response",
     *      description="Internal response",
     *      example="Lorem ipsum dolor..."
     * )
     *
     * @var string
     */
    public $internalResponse;

    /**
     * @OA\Property(
     *      title="Response for citizen",
     *      description="Response for citizen",
     *      example="Lorem ipsum dolor..."
     * )
     *
     * @var string
     */
    public $responseForCitizen;

    /**
     * @OA\Property(
     *      title="Location",
     *      description="Location coordinates in Json format, lat, lng",
     *      example="{lat: 545455, lng: 445422}"
     * )
     *
     * @var string
     */
    public $location;

    /**
     * @OA\Property(
     *      title="Address",
     *      description="Address for the incidence",
     *      example="4th street #5"
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *      title="State",
     *      description="State model",
     *
     * )
     *
     * @var  State
     */
    public $state;

    /**
     * @OA\Property(
     *      title="Tag",
     *      description="Tag model"
     * )
     *
     * @var  Tag
     */
    public $tag;

    /**
     * @OA\Property(
     *      title="Public Center",
     *      description="Public Center model"
     * )
     *
     * @var  PublicCenter
     */
    public $publicCenter;

    /**
     * @OA\Property(
     *      title="Neighborhood",
     *      description="Neighborhood model",
     *
     * )
     *
     * @var  Neighborhood
     */
    public $neighborhood;

    /**
     * @OA\Property(
     *      title="District",
     *      description="District model",
     *
     * )
     *
     * @var  District
     */
    public $district;


    /**
     * @OA\Property(
     *      title="Street",
     *      description="Street model",
     *
     * )
     *
     * @var  Street
     */
    public $street;

    /**
     * @OA\Property(
     *       title="Assigned To",
     *       description="Worker assigned for the incidence",
     *
     * )
     *
     * @var  User
     */
    public $assignedTo;

    /**
     * @OA\Property(
     *       title="User",
     *       description="User who send the Incidence"
     * )
     *
     * @var  User
     */
    public $user;


    /**
     * @OA\Property(
     *      title="Images",
     *      description="Array of images",
     *
     * )
     *
     * @var  IncidenceImage[]
     */
    public $images;

    /**
     * @OA\Property(
     *     title="Deadline",
     *     description="Deadline",
     *     example="2020-01-27 17:50",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deadline;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updatedAt;
}
