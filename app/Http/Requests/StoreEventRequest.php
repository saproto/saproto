<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]|string|ValidationRule>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'start' => ['required', 'gte:end'],
            'location' => ['required', 'max:255', 'string'],
            'secret' => ['required'],
            'description' => ['required'],
            'summary' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    /** @return string[] */
    #[Override]
    public function messages(): array
    {
        return [
            'gte' => 'The Event cannot end before it begins!', ];
    }
}
