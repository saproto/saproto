<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MP3Request extends FormRequest
{
    /**
     * @return array<string, string[]|string|ValidationRule>
     *                                                       Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sound' => ['required', 'mimes:audio/mpeg,mp3,mpga', 'max:200'],
        ];
    }
}
