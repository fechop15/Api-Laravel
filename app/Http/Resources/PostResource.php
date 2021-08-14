<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            "type" => "posts",
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                'content' => $this->content,
                'is_published' => $this->is_published,
                'total_comments' => $this->comments->count(),
                "created" => $this->created_at,
                "updated" => $this->updated_at
            ],
            'relationships' => [
                'comments' => CommentResource::collection($this->comments->take(5)),
                'user' => new UserResource($this->user)
            ]
        ];
    }
}
