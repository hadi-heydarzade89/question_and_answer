<?php

namespace App\Http\Resources\API\V1\Question;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'question_title' => $this->title,
            'content' => $this->content,
            'author_name' => $this->user->first_name . ' ' . $this->user->last_name,
            'author_link' => route('v1.user.profile', ['userSlug' => $this->user->user_slug]),
        ];
    }
}
