<?php

namespace App\Repositories\Contracts;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface AnswerRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Builder|Model|null
     */
    public function show(int $id): Builder|Model|null;

    /**
     * @param int $id
     * @param string $answer
     * @param User $user
     * @return bool|null
     */
    public function updateOwnAnswer(int $id, string $answer, User $user): ?bool;

    /**
     * @param int $id
     * @param User $user
     * @return bool|null
     */
    public function deleteOwnAnswer(int $id, User $user): ?bool;

    /***
     * @param int $questionId
     * @param User $user
     * @param string $answer
     * @return Answer
     */
    public function storeAnswer(int $questionId,User $user, string $answer): Answer;

    /**
     * @param int $id
     * @param User $user
     * @return Answer|null
     */
    public function getOwnedAnswer(int $id, User $user): ?Answer;

}
