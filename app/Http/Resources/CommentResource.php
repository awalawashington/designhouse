<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "user" => new UserResource($this->user),
            "body" => $this->body,
            "created_dates" => [
                "created_at_humans" => $this->created_at->diffForHumans(),
                "created_at" => $this->created_at
            ],
            "updated_dates" => [
                "updated_at_humans" => $this->updated_at->diffForHumans(),
                "updated_at" => $this->updated_at
            ]
        ];
    }
}
