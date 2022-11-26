<?php

namespace App\Providers;

use App\Repositories\AnswerRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\QuestionRepository;
use App\Repositories\UserRepository;
use App\Services\AnswerService;
use App\Services\Contracts\AnswerServiceInterface;
use App\Services\Contracts\QuestionServiceInterface;
use App\Services\QuestionService;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class QuestionAndAnsweProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Repositories
         */
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AnswerRepositoryInterface::class, AnswerRepository::class);

        /*
         * Services
         */
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->app->bind(QuestionServiceInterface::class,QuestionService::class);
        $this->app->bind(AnswerServiceInterface::class,AnswerService::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Responses
         */

        Response::macro('success', function (string $message, $data) {
            return response()->json([
                'status' => 1,
                'message' => $message,
                'data' => $data
            ],
                Response::HTTP_OK
            );
        });


        Response::macro('error', function ($message = '') {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'data' => null,
            ], 500);
        });

        Response::macro('noContent', function ($message) {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'data' => null,
            ],
                Response::HTTP_NO_CONTENT
            );
        });
        Response::macro('notFound', function ($message = '') {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'data' => null
            ],
                Response::HTTP_NOT_FOUND
            );
        });

        Response::macro('conflict', function ($message) {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $message,
                    'data' => null,
                ],
                Response::HTTP_CONFLICT
            );
        });
        Response::macro('gone', function ($message) {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $message,
                    'data' => null,
                ],
                Response::HTTP_GONE
            );
        });
        Response::macro('forbidden', function ($message = '') {
            return response()->json(
                [
                    'status' => 0,
                    'message' => $message,
                    'data' => null,
                ],
                Response::HTTP_FORBIDDEN
            );
        });
        Response::macro('unauthorized', function () {
            return response()->json(
                [
                    'status' => 0,
                    'message' => __('question_and_answer.users.unauthorized'),
                    'data' => null,
                ],
                Response::HTTP_UNAUTHORIZED
            );
        });

        Response::macro('unprocessableContent', function ($message, $data = []) {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'date' => $data
            ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        });

        Response::macro('created', function ($message, $data) {
            return response()->json([
                'status' => 1,
                'message' => $message,
                'date' => $data
            ],
                Response::HTTP_CREATED
            );
        });
        Response::macro('methodNotAllowed', function ($message) {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'date' => null
            ],
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        });

        Response::macro('badRequest', function ($message = '') {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'date' => null
            ],
                Response::HTTP_BAD_REQUEST
            );
        });
    }
}
