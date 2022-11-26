<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\User;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use App\Services\Contracts\AnswerServiceInterface;
use HadiHeydarzade89\QuestionAndAnswer\Enums\ItsTrueAnswerEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnswerService implements AnswerServiceInterface
{

    public function __construct(
        private AnswerRepositoryInterface $answerRepository
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getPaginatedAnswer(): LengthAwarePaginator
    {
        return $this->answerRepository->index();
    }

    /**
     * @inheritDoc
     */
    public function createAnswer(User $user, int $questionId, string $answer): Answer
    {
        return $this->answerRepository->storeAnswer($questionId, $user, $answer);
    }

    /**
     * @inheritDoc
     */
    public function updateOwnAnswer(User $user, int $id, string $answer): ?Answer
    {
        $answer = $this->answerRepository->updateOwnAnswer($id, $answer, $user);
        if ($answer === false or is_null($answer)) {
            throw new BadRequestHttpException();
        } else {
            return $this->answerRepository->show($id);
        }

    }

    /**
     * @inheritDoc
     */
    public function deleteOwnAnswer(User $user, $id): ?bool
    {
        $answer = $this->answerRepository->deleteOwnAnswer($id, $user);

        if ($answer === false or is_null($answer)) {
            throw new BadRequestHttpException();
        } else {
            return $answer;
        }
    }

    /**
     * @inheritDoc
     */
    public function showAnswer(int $id): Builder|Model
    {
        $answer = $this->answerRepository->show($id);
        if (is_null($answer)) {
            throw new NotFoundHttpException();
        }
        return $answer;
    }

    public function setRightAnswer(int $id, User $user): Builder|Model
    {
        $answer = $this->answerRepository->getOwnedAnswer($id, $user);
        if (is_null($answer)) {
            throw new AccessDeniedHttpException();
        }
        DB::transaction(function () use ($answer) {
            $this->answerRepository->update(
                ['its_true' => ItsTrueAnswerEnum::WRONG_ANSWER],
                'question_id',
                $answer->question_id
            );
            $this->answerRepository->update(
                ['its_true' => ItsTrueAnswerEnum::RIGHT_ANSWER],
                'id',
                $answer->id
            );
        });
        return $this->answerRepository->show($id);
    }
}
