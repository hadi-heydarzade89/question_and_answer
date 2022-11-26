<?php

namespace App\Services\Contracts;

use App\Models\Question;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface QuestionServiceInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function questionList(): LengthAwarePaginator;

    /**
     * @param array $data
     * @param User $user
     * @return Question
     */
    public function storeQuestion(array $data, User $user): Question;

    /**
     * @param int $id
     * @return Question|null
     */
    public function getQuestion(int $id): ?Question;

    /**
     * @param array $data
     * @param int $id
     * @param User $user
     * @return bool
     */
    public function updateQuestion(array $data, int $id, User $user): bool;

    /**
     * @param int $id
     * @param User $user
     * @return bool|null
     */
    public function deleteQuestion(int $id, User $user): ?bool;
}
