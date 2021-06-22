<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phoneNumber' => $this->phoneNumber,
            'role' => $this->userRole[0]->name,
            'filters' => $this->filters
        ];
    }

    public static function forList($users): array
    {
        $results = [];
        foreach ($users as $user){
            $results[] = [
                'id' => $user->id,
                'name' => $user->name,
                'lastName' => $user->lastName,
                'email' => $user->email,
                'phoneNumber' => $user->phoneNumber,
            ];
        }

        return $results;
    }
}
