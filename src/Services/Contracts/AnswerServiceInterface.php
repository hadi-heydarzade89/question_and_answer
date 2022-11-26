<?php

namespace App\Services\Contracts;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface AnswerServiceInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedAnswer(): LengthAwarePaginator;

    /**
     * @param User $user
     * @param int $questionId
     * @param string $answer
     * @return Answer|null
     */
    public function createAnswer(User $user, int $questionId, string $answer): ?Answer;

    /**
     * @param User $user
     * @param int $id
     * @param string $answer
     * @return Answer|null
     */
    public function updateOwnAnswer(User $user, int $id, string $answer): ?Answer;

    /**
     * @param User $user
     * @param $id
     * @return bool|null
     */
    public function deleteOwnAnswer(User $user, $id): ?bool;

    /**
     * @param int $id
     * @return Builder|Model
     */
    public function showAnswer(int $id): Builder|Model;

    /**
     * @param int $id
     * @param User $user
     * @return Builder|Model
     */
    public function setRightAnswer(int $id, User $user): Builder|Model;
}
