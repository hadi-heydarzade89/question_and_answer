<?php

namespace App\Http\Resources\API\V1\Answer;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'question_id' => $this->question_id,
            'answer' => $this->content,
            'author_name' => $this->user->name,
            'author_last_name' => $this->user->last_name,
            'author_link' => route('v1.user.profile', ['userSlug' => $this->user->user_slug]),
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
