<?php

namespace App\Http\Requests;

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

    #[Override]
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->has('is_featured'),
            'is_external' => $this->has('is_external'),
            'involves_food' => $this->has('involves_food'),
            'force_calendar_sync' => $this->has('force_calendar_sync'),
            'publication' => $this->has('publication') ? $this->input('publication') : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'summary' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start' => ['required', 'date', 'gte:end'],
            'end' => ['required', 'date'],
            'location' => ['required', 'string'],
            'secret' => ['required', 'boolean'],
            'category' => ['required', 'string'],
            'image' => ['image'],
            'maps_location' => ['nullable'],
            'is_featured' => ['boolean'],
            'is_external' => ['boolean'],
            'involves_food' => ['boolean'],
            'force_calendar_sync' => ['boolean'],
            'publication' => ['nullable', 'date'],
            'committee' => ['nullable', 'string'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'gte' => 'The Event cannot end before it begins!', ];
    }
}
