<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "type" => "comments",
            'id' => $this->id,
            'attributes' => [
                'content' => $this->content,
                'is_published' => $this->is_published,
                "created" => $this->created_at,
                "updated" => $this->updated_at
            ],
            'relationships' => [
                'user' => new UserResource($this->user)
            ]
        ];
    }
}
