<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = json_decode($this->changes);
        $changes = [];
        foreach ($data as $change){
            $changes[] = $change->field;
        }
        return [
            'id' => $this->id,
            'incidence' => $this->incidence_id,
            'changes' =>  implode(',',$changes),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'user' => $this->user->name.' '.$this->user->lastName
        ];
    }
}
