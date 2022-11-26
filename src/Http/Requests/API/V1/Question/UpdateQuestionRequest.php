<?php

namespace App\Http\Requests\API\V1\Question;

use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultPermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (auth('sanctum')->user()?->hasAnyPermission(DefaultPermissionsEnum::UPDATE_QUESTION->value)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string|min:1|max:255',
            'content' => 'string|min:4',
            'status' => [
                'nullable',
                'bool',
                Rule::in(array_column(\HadiHeydarzade89\QuestionAndAnswer\Enums\QuestionStatusEnum::cases(), 'value'))
            ]
        ];
    }
}
