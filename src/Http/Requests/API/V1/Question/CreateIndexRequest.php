<?php

namespace App\Http\Requests\API\V1\Question;

use HadiHeydarzade89\QuestionAndAnswer\Enums\DefaultPermissionsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (auth('sanctum')->user()?->hasAnyPermission(DefaultPermissionsEnum::CREATE_QUESTION->value)) {
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
            'title' => 'required|string|min:1|max:255',
            'content' => 'required|string|min:4',
            'status' => [
                'nullable',
                'bool',
                Rule::in(array_column(\HadiHeydarzade89\QuestionAndAnswer\Enums\QuestionStatusEnum::cases(), 'value'))
            ]
        ];
    }
}
