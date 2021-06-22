<?php

namespace App\Http\Resources;

use App\Area;
use App\Incidence;
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
            'street' => null !== $this->street ? new StreetResource($this->street) : null,
            'neighbor' => null !== $this->neighbor ? new NeighborResource($this->neighbor) : null,
            'responseForCitizen' => $this->responseForCitizen,
            'tags' => $tags,
            'user' => new UserResource($this->user),
            'area' => null !== $this->area ?  new AreaResource($this->area) : null,
            'assignedTo' => null !== $this->assignedTo ? new UserResource($this->assignedTo) : null,
            'state' => null !== $this->state ? new StateResource($this->state) : null,
            'public_center' => null !==  $this->public_center ? new PublicCenterResource($this->public_center) : null,
            'enrolment' => null !== $this->enrolment ? new EnrolmentResource($this->enrolment) : null,
            'deadline' => $this->created_at->format('d/m/Y'),
            'createdAt' => $this->created_at->format('d/m/Y h:i'),
            'updatedAt' => $this->updated_at->format('d/m/Y h:i'),
            'images' =>  $images,
        ];
    }

    /**
     * Export incidences
     *
     */
    public static function export(){
        $datas = Incidence::select('incidence.*')
            ->with('user','tags','state','street','area','assignedTo','publicCenter','enrolment','district')
            ->get();

        $json_data = [];

        foreach ($datas as $data){
            $tags = '';
            foreach($data->tags as $tag){
                $tags = $tag->name .',';
            }
            $json_data[] = [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
                'location' => $data->location,
                'address' => $data->address,
                'street' => $data->street?$data->street->street:'',
                'neighborhood' => $data->neighborhood?$data->neighborhood->name:'',
                'tags' => $tags,
                'user' => $data->user ? $data->user->email : '',
                'area' => $data->area?$data->area->name:'',
                'assignedTo' => $data->assignedTo?$data->assignedTo->email:'',
                'state' => $data->state?$data->state->name:'',
                'public_center' => $data->public_center?$data->public_center->name:'',
                'enrollment' => $data->enrollment?$data->enrollment->name:'',
                'created_at' => $data->created_at,
                'district' => $data->district?$data->district->name:'',
            ];
        }

        return $json_data;
    }
}
