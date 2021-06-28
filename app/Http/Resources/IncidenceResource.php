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

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'address' => $this->address,
            'street' => null !== $this->street ? new StreetResource($this->street) : null,
            'district' => null !== $this->district ? new DistrictResource($this->district) : null,
            'neighborhood' => null !== $this->neighborhood ? new NeighborhoodResource($this->neighborhood) : null,
            'responseForCitizen' => $this->responseForCitizen,
            'internalResponse' => $this->internalResponse,
            'tag' =>  null !== $this->tag ?  new TagResource($this->tag) : null,
            'priority' =>  null !== $this->priority ?  new PriorityResource($this->priority) : null,
            'equipment' =>  null !== $this->equipment ?  new EquipmentResource($this->equipment) : null,
            'user' => new UserResource($this->user),
            'area' => null !== $this->area ?  new AreaResource($this->area) : null,
            'assignedTo' => null !== $this->assignedTo ? new UserResource($this->assignedTo) : null,
            'state' => null !== $this->state ? new StateResource($this->state) : null,
            'publicCenter' => null !==  $this->public_center ? new PublicCenterResource($this->public_center) : null,
            'enrolment' => null !== $this->enrolment ? new EnrolmentResource($this->enrolment) : null,
            'deadline' => $this->deadline,
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
            ->with('user','tag','state','priority','equipment','street','area','assignedTo','publicCenter','enrolment','district')
            ->get();

        $json_data = [];

        foreach ($datas as $data){
            $json_data[] = [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
                'location' => $data->location,
                'address' => $data->address,
                'street' => $data->street ? $data->street->street : '',
                'priority' => $data->priority ? $data->priority->name : '',
                'equipment' => $data->equipment ? $data->equipment->name : '',
                'neighborhood' => $data->neighborhood ? $data->neighborhood->name:'',
                'tag' =>  null !== $data->tag ?  new TagResource($data->tag) : null,
                'user' => $data->user ? $data->user->email : '',
                'area' => $data->area ? $data->area->name :'',
                'assignedTo' => $data->assignedTo ? $data->assignedTo->email : '',
                'state' => $data->state ? $data->state->name:'',
                'public_center' => $data->public_center ? $data->public_center->name : '',
                'enrollment' => $data->enrollment ? $data->enrollment->name : '',
                'created_at' => $data->created_at,
                'district' => $data->district ? $data->district->name : '',
            ];
        }

        return $json_data;
    }
}
