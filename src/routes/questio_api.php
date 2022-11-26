<?php


use App\Http\Controllers\API\V1\AnswerController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->as('v1.')->group(function () {
    Route::get('users/{userSlug}')->name('user.profile');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::middleware('auth:sanctum')->group(function () {
        //////////////////////////////// Questions ////////////////////////////////
        Route::prefix('question.')->group(function () {

            Route::resource('/', QuestionController::class)->only(['update', 'destroy', 'store']);
            Route::post('/{id}/answer', [AnswerController::class, 'store'])->name('answer.store');
            Route::resource('/', QuestionController::class)->only(['index', 'show']);

        });

        //////////////////////////////// Answers ////////////////////////////////
        Route::as('answer.')->prefix('answers')->group(function () {

            Route::get('/{id}/right-answer', [AnswerController::class, 'setRightAnswer'])->name('index')
                ->where(['id' => '[0-9]+']);

            Route::put('/{id}')->where('answer', [AnswerController::class, 'update'])->name('update')
                ->where(['id' => '[0-9]+']);

            Route::delete('/{id}', [AnswerController::class, 'delete'])->name('delete')
                ->where(['id' => '[0-9]+']);


            Route::get('/', [AnswerController::class, 'index'])->name('index');
            Route::get('/{id}', [AnswerController::class, 'show'])->name('show');


        });
    });

});
