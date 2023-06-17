<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'nullable', 'unique:posts,title,' . $this->post->id],
            'excerpt' => ['sometimes', 'nullable'],
            'slug' => ['sometimes', 'nullable', 'unique:posts,title,' . $this->post->id],
            'body' => ['sometimes', 'nullable', 'min:200']
        ];
    }
}
