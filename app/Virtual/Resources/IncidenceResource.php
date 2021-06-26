<?php


namespace App\Virtual\Resources;

use App\Virtual\Models\Incidence;

/**
 * @OA\Schema(
 *     title="IncidenceResource",
 *     description="Incidence resource",
 *     @OA\Xml(
 *         name="IncidenceResource"
 *     )
 * )
 */
class IncidenceResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Incidence[]
     */
    private $data;
}
