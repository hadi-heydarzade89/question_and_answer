<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\API\V1\User\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use HadiHeydarzade89\QuestionAndAnswer\Enums\UserStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{

    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @OA\Post(
     *     operationId="login",
     *     tags={"Authentication"},
     *     path="/api/v1/login",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                    type="object",
     *                    @OA\Property(
     *                        type="string",
     *                        property="email"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="password"
     *                    )
     *                  ),
     *                  example={
     *                      "email": "example@example.com",
     *                      "password": "secret1234"
     *                  }
     *              ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent()
     *     ),
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request)
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = auth('sanctum')->user();
            return Response::success(__(''), [
                'token' => $auth->createToken('LaravelSanctumAuth')->plainTextToken
            ]);
        } else {
            return Response::unauthorized();
        }
    }

    /**
     * @OA\Post(
     *     operationId="register",
     *     tags={"Authentication"},
     *     path="/api/v1/register",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                    type="object",
     *                    @OA\Property(
     *                        type="string",
     *                        property="email"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="name"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="last_name"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="password"
     *                    ),
     *                    @OA\Property(
     *                        type="string",
     *                        property="confirm_password"
     *                    )
     *                  ),
     *                  example={
     *                      "email": "example@example.com",
     *                      "password": "secret1234",
     *                      "confirm_password": "secret1234",
     *                      "name": "test",
     *                      "last_name": "testi",
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
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        return Response::created(__('question_and_answer.users.user_created'), UserResource::make(
            $this->userRepository->create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'user_slug' => Str::random(15),
                'status' => UserStatusEnum::ACTIVE->value,
                'password' => bcrypt($request->password, [
                    'rounds' => config('question_and_answer.bcrypt_iteration')
                ]),
            ])
        ));
    }
}
