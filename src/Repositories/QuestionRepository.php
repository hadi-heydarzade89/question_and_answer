<?php

namespace App\Repositories;

use App\Models\Question;
use App\Models\User;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{

    public function __construct(Question $question)
    {
        parent::__construct($question);
    }

    /**
     * @inheritDoc
     */
    public function questions(): LengthAwarePaginator
    {
        return $this->model->with(['user'])->orderBy('created_at', 'desc')->paginate(config('app.per_page'));
    }

    /**
     * @inheritDoc
     */
    public function store(array $question): Question
    {
        return $this->model->create($question);
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id, User $user): bool
    {

        return $this->model->where('id', $id)->where('user_id', $user->id)->updateOrFail($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, User $user): ?bool
    {
        return $this->model->where('id', $id)->where('user_id', $user->id)->deleteOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getUserQuestion(int $id, int $userId): ?Question
    {
        return $this->model->where('id', $id)->where('user_id', $id)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getQuestion(int $id, User $user = null): ?Question
    {
        $question = $this->model->where('id', $id);
        if (is_null($user) === false) {
            $question = $question->where('user_id', $user->id);
        }
        return $question->first();
    }
}
