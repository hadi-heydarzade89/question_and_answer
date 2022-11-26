<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Question\CreateIndexRequest;
use App\Http\Requests\API\V1\Question\DeleteQuestionRequest;
use App\Http\Requests\API\V1\Question\QuestionIndexRequest;
use App\Http\Requests\API\V1\Question\UpdateQuestionRequest;
use App\Http\Resources\API\V1\Question\QuestionResource;
use App\Services\Contracts\QuestionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class QuestionController extends Controller
{

    public function __construct(private QuestionServiceInterface $questionService)
    {
    }

    /**
     * @OA\Get(
     *     operationId="questions-index",
     *     tags={"Questions"},
     *     security={ {"sanctum": {} }},
     *      path="/api/v1/questions",
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
     * @param QuestionIndexRequest $request
     * @return JsonResponse
     */
    public function index(QuestionIndexRequest $request)
    {
        return Response::success('', QuestionResource::collection($this->questionService->questionList()));
    }

    /**
     * @OA\Post(
     *     operationId="store-question",
     *     tags={"Questions"},
     *     security={ {"sanctum": {} }},
     *     path="/api/v1/questions",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                    type="object",
     *                    @OA\Property(
     *                        type="string",
     *                        property="title"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="content"
     *                    ),
     *                    @OA\Property(
     *                        type="boolean",
     *                        property="status"
     *                    )
     *                  ),
     *                  example={
     *                      "title": "test question",
     *                      "content": "sample content",
     *                      "status": false,
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
     * @param CreateIndexRequest $request
     * @return JsonResponse
     */
    public function store(CreateIndexRequest $request)
    {
        return Response::created(
            $this->questionService->storeQuestion(
                $request->only(array_keys($request->rules())),
                auth('sanctum')->user()
            ),
            __('question_and_answer.questions.create_a_question'),

        );
    }

    /**
     * @OA\Get(
     *     operationId="questions-show",
     *     tags={"Questions"},
     *     security={ {"sanctum": {} }},
     *      path="/api/v1/questions/{id}",
     *     @OA\Parameter(
     *       in="path",
     *       name="id",
     *       required=true,
     *       @OA\Schema(type="number"),
     *       example="1"
     *     ),
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
        return Response::success('', (new QuestionResource($this->questionService->getQuestion($id))));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        // todo
    }

    /**
     * @OA\Put(
     *     operationId="update-question",
     *     tags={"Questions"},
     *     security={ {"sanctum": {} }},
     *     path="/api/v1/questions/{id}",
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
     *                        property="title"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="content"
     *                    ),
     *                    @OA\Property(
     *                        type="boolean",
     *                        property="status"
     *                    )
     *                  ),
     *                  example={
     *                      "title": "test question",
     *                      "content": "sample content",
     *                      "status": false,
     *                  }
     *              ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="updated",
     *          @OA\JsonContent()
     *     ),
     * )
     * @param UpdateQuestionRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateQuestionRequest $request, int $id)
    {
        return Response::success(
            __('question_and_answer.questions.update_question'),
            $this->questionService->updateQuestion(
                $request->only(array_keys($request->rules())),
                $id,
                auth('sanctum')->user()
            )
        );
    }

    /**
     * @OA\Delete(
     *     operationId="delete-question",
     *     tags={"Questions"},
     *     security={ {"sanctum": {} }},
     *     path="/api/v1/questions/{id}",
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
     * @param int $id
     * @param DeleteQuestionRequest $request
     * @return JsonResponse
     */
    public function destroy(int $id, DeleteQuestionRequest $request)
    {
        return Response::success(
            __('question_and_answer.questions.delete_question'),
            $this->questionService->deleteQuestion($id,auth('sanctum')->user())
        );
    }
}
