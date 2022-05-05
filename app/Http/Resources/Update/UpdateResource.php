<?php

namespace App\Http\Resources\Update;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user' => new UserResource($this->whenLoaded('user')),
            'requested_by' => new UserResource($this->whenLoaded('requester')),
            'type' =>$this->type,
            'details' => $this->details,
            'confirmed_by' => new UserResource($this->whenLoaded('confirmer')),
            'confirmed_at' => $this->confirmed_at?->toDayDateTimeString(),
            'created_at' => $this->created_at->toDayDateTimeString(),
            'updated_at' => $this->updated_at->toDayDateTimeString()
        ];
    }
}
