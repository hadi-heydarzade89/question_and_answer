<?php

namespace App\Repositories\Contracts;

use App\Models\Question;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface QuestionRepositoryInterface
{

    /**
     * @return LengthAwarePaginator
     */
    public function questions(): LengthAwarePaginator;

    /**
     * @param array $question
     * @return Question
     */
    public function store(array $question): Question;

    /**
     * @param array $data
     * @param int $id
     * @param User $user
     * @return bool
     */
    public function update(array $data, int $id, User $user): bool;

    /**
     * @param int $id
     * @param User $user
     * @return bool|null
     */
    public function delete(int $id, User $user): ?bool;

    /**
     * @param int $id
     * @param int $userId
     * @return Question|null
     */
    public function getUserQuestion(int $id, int $userId): ?Question;

    /**
     * @param int $id
     * @param User|null $user
     * @return Question|null
     */
    public function getQuestion(int $id, User $user = null): ?Question;

}
