<?php

namespace App\Http\Requests\API\V1\Answer;

use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultPermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;

class AnswerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (auth('sanctum')->user()?->hasAnyPermission(DefaultPermissionsEnum::CREATE_ANSWER->value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'answer' => 'required|string|min:3'
        ];
    }
}
