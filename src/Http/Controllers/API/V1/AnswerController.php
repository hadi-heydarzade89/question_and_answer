<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Answer\AnswerCreateRequest;
use App\Http\Requests\API\V1\Answer\AnswerDeleteRequest;
use App\Http\Requests\API\V1\Answer\AnswerIndexRequest;
use App\Http\Requests\API\V1\Answer\AnswerUpdateRequest;
use App\Http\Requests\API\V1\Answer\RightAnswerRequest;
use App\Http\Resources\API\V1\Answer\AnswerResource;
use App\Services\Contracts\AnswerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class AnswerController extends Controller
{
    public function __construct(
        private AnswerServiceInterface $answerService
    )
    {
    }

    /**
     * @OA\Get(
     *     operationId="answers-index",
     *     description="Display list of answers",
     *     tags={"Answers"},
     *     security={ {"sanctum": {} }},
     *      path="/api/v1/answers",
     *     @OA\Parameter(
     *       in="query",
     *       name="page",
     *       required=false,
     *       @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     * )
     * @param AnswerIndexRequest $request
     * @return JsonResponse
     */
    public function index(AnswerIndexRequest $request)
    {
        return Response::success('', AnswerResource::collection($this->answerService->getPaginatedAnswer()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     operationId="store-answer",
     *     description="create a answer",
     *     tags={"Answers"},
     *     security={ {"sanctum": {} }},
     *     path="/api/v1/questions/{id}/answer",
     *     @OA\Parameter(
     *       in="path",
     *       name="id",
     *       required=true,
     *       @OA\Schema(type="number"),
     *       example="1"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                    type="object",
     *                    @OA\Property(
     *                        type="string",
     *                        property="answer"
     *                    ),
     *                  ),
     *                  example={
     *                      "answer": "test answer",
     *                  }
     *              ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="created",
     *          @OA\JsonContent()
     *     ),
     * )
     * @param AnswerCreateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function store(AnswerCreateRequest $request, int $id)
    {
        return Response::created(__(), $this->answerService->createAnswer(
            auth('auth:sanctum')->user(),
            $id,
            $request->answer
        ));
    }

    /**
     * @OA\Get(
     *     operationId="show-answer",
     *     description="Display an answer",
     *     tags={"Answers"},
     *     security={ {"sanctum": {} }},
     *      path="/api/v1/answers/{id}",
     *     @OA\Parameter(
     *       in="path",
     *       name="id",
     *       required=false,
     *       @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     * )
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return Response::success('', $this->answerService->showAnswer($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     operationId="update-answer",
     *     description="update an answer",
     *     tags={"Answers"},
     *     security={ {"sanctum": {} }},
     *     path="/api/v1/answers/{id}",
     *     @OA\Parameter(
     *       in="path",
     *       name="id",
     *       required=true,
     *       @OA\Schema(type="number"),
     *       example="1"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                    type="object",
     *                    @OA\Property(
     *                        type="string",
     *                        property="answer"
     *                    ),
     *                      example={
     *                          "answer": "test question"
     *                      }
     *                  ),
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="updated",
     *          @OA\JsonContent()
     *     ),
     * )
     * @param AnswerUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AnswerUpdateRequest $request, int $id)
    {
        return Response::success(__('Answer with :id updated', ['id' => $id]),
            $this->answerService->updateOwnAnswer(
                auth('sanctum')->user(),
                $id,
                $request->answer
            ));
    }

    /**
     * @OA\Delete(
     *     operationId="delete-answer",
     *     description="Delete an answer",
     *     tags={"Answers"},
     *     security={ {"sanctum": {} }},
     *     path="/api/v1/answers/{id}",
     *     @OA\Parameter(
     *       in="path",
     *       name="id",
     *       required=true,
     *       @OA\Schema(type="number"),
     *       example="1"
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="deleted",
     *          @OA\JsonContent()
     *     ),
     * )
     * @param AnswerDeleteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(AnswerDeleteRequest $request, int $id)
    {
        return Response::success(
            __('Your answer has been removed.'),
            $this->answerService->deleteOwnAnswer(auth('sanctum')->user(), $id));
    }

    /**
     * @OA\Get(
     *     operationId="set-right-answer",
     *     description="Set right answer",
     *     tags={"Answers"},
     *     security={ {"sanctum": {} }},
     *      path="/api/v1/answers/{id}/right-answer",
     *     @OA\Parameter(
     *       in="query",
     *       name="page",
     *       required=false,
     *       @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     * )
     * @param int $id
     * @param RightAnswerRequest $request
     * @return JsonResponse
     */
    public function setRightAnswer(int $id, RightAnswerRequest $request)
    {
        return Response::success(
            __('question_and_answer.answer.right_answer_is_set'),
            $this->answerService->setRightAnswer($id, auth('sanctum')->user()));
    }
}
