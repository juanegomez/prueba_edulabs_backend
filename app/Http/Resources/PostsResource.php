<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category_name' => $this->category ? $this->category->name : '',
            'user_name' => $this->user ? $this->user->name : '',
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y h:i A'),
        ];
    }
}
