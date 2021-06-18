<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            $images[] = new NewsImageResource($image);
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'content' => $this->content,
            'author' => trim($this->user->name.' '.$this->user->lastName),
            'createdAt' => $this->created_at->format('d/m/Y h:i'),
            'updatedAt' => $this->updated_at->format('d/m/Y h:i'),
            'images' =>  $images,
            'category_id' => $this->category_id
        ];
    }
}
