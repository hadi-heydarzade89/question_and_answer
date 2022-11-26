<?php

namespace App\Http\Requests\API\V1\Answer;

use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultPermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;

class AnswerDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (auth('sanctum')->user()?->hasAnyPermission(DefaultPermissionsEnum::DELETE_ANSWER->value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
