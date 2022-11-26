<?php

namespace App\Repositories;


use App\Models\Answer;
use App\Models\User;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class AnswerRepository extends BaseRepository implements AnswerRepositoryInterface
{

    public function __construct(Answer $answer)
    {
        parent::__construct($answer);
    }

    /**
     * @inheritDoc
     */
    public function index(): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(config('app.per_page'));
    }

    /**
     * @inheritDoc
     */
    public function show(int $id): Builder|Model|null
    {
        return $this->model->with([
            'user' => fn($q) => $q->select(['id', 'name', 'last_name', 'user_slug']),
        ])->where('id', $id)->first();
    }

    /**
     * @inheritDoc
     */
    public function updateOwnAnswer(int $id, string $answer, User $user): ?bool
    {
        return $this->model->where('id', $id)->where('user_id', $user->id)->updateOrFail([
            'content' => $answer,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function deleteOwnAnswer(int $id, User $user): ?bool
    {
        return $this->model->where('id', $id)->where('user_id', $user->id)->deleteOrFail();
    }

    /**
     * @inheritDoc
     */
    public function storeAnswer(int $questionId, User $user, string $answer): Answer
    {
        return $this->model->create([
            'user_id' => $user->id,
            'question_id' => $questionId,
            'content' => $answer,
        ]);
    }

    /**
     * @param int $id
     * @param User $user
     * @return Answer|null
     */
    public function getOwnedAnswer(int $id, User $user): ?Answer
    {
        return $this->model->where('id', $id)->where('user_id', $user->id)->first();
    }
}
