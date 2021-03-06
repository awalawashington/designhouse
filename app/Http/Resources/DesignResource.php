<?php

namespace App\Http\Resources;


use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "slug" => $this->slug,
            "images" => $this->images,
            "is_live" => $this->is_live,
            "tag_list" => [
                'tags' => $this->tagArray,
                'normalized' => $this->tagArrayNormalized,
            ],
            "created_dates" => [
                "created_at_humans" => $this->created_at->diffForHumans(),
                "created_at" => $this->created_at
            ],
            "updated_dates" => [
                "updated_at_humans" => $this->updated_at->diffForHumans(),
                "updated_at" => $this->updated_at
            ],
            "likes_count" => $this->likes()->count(),
            "user" => new UserResource($this->whenLoaded('user')),
            "comments" => CommentResource::collection($this->whenLoaded('comments')),
            "team" => $this->team ? [
                'name' => $this->team->name,
                'slug' => $this->team->slug
            ] : null,
        ];
    }
}
