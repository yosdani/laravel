<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = [];
        foreach ($this->images as $image){
            $images[] = new IncidenceImageResource($image);
        }
        $tags = [];
        foreach ($this->tags as $tag){
            $tags[] = new TagResource($tag);
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'address' => $this->address,
            'street' => new StreetResource($this->street),
            'neighbor' => new NeighborResource($this->neighbor),
            'responseForCitizen' => $this->responseForCitizen,
            'tags' => $tags,
            'user' => new UserResource($this->user),
            'area' => new AreaResource($this->area),
            'assignedTo' => new UserResource($this->assignedTo),
            'state' => new StateResource($this->state),
            'public_center' => new PublicCenterResource($this->public_center),
            'enrolment' => new EnrolmentResource($this->enrolment),
            'deadline' => $this->created_at->format('d/m/Y'),
            'createdAt' => $this->created_at->format('d/m/Y h:i'),
            'updatedAt' => $this->updated_at->format('d/m/Y h:i'),
            'images' =>  $images,
        ];
    }
}
