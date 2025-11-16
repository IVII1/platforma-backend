<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'role' => 'required|in:student,admin,teacher',
            'picture' => 'image|mimes:png,jpg,jpeg|size:2048',
            'password' => 'required|string|min:8',
            'grade_book' => 'nullable|regex:^[1-9]\d?/\d{2}$'

        ];
    }
}
