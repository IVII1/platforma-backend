<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
            'attachment_type' => 'required|in:file,article,external_link',
            'attachment_path' => 'required_unless:attachemt_type,article|string',
            'attachemnt_name' => 'required|string',
            'article_content' => 'required_if:attachment_type,article'
        ];
    }
}
