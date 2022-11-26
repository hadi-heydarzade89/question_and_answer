<?php

namespace App\Services;


use App\Models\Question;
use App\Models\User;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Services\Contracts\QuestionServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class QuestionService implements QuestionServiceInterface
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function questionList(): LengthAwarePaginator
    {
        return $this->questionRepository->questions();
    }

    /**
     * @inheritDoc
     */
    public function storeQuestion(array $data, User $user): Question
    {
        return $this->questionRepository->store(array_merge($data, ['user_id' => $user->id]));
    }

    /**
     * @inheritDoc
     */
    public function getQuestion(int $id): ?Question
    {
        return $this->questionRepository->getQuestion($id);
    }

    /**
     * @inheritDoc
     */
    public function updateQuestion(array $data, int $id, User $user): bool
    {
        $this->questionRepository->getUserQuestion($id, $user->id);
        return $this->questionRepository->update($data, $id, $user);
    }

    /**
     * @inheritDoc
     */
    public function deleteQuestion(int $id, User $user): ?bool
    {
        return $this->questionRepository->delete($id, $user);
    }
}
