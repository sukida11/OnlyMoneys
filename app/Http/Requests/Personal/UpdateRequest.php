<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'avatar' => 'file',
            'username' => ['required', 'string', Rule::unique('users')->ignore($this->user->id)],
            'email' => ['required', 'string', 'email', Rule::unique('users')->ignore($this->user->id)],
            'name' => ['required', 'string'],
            'bio' => ['string']
        ];
    }
}
