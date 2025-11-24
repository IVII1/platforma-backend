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
            'attachment' => 'required_if:attachemt_type,file|file|mimes:txt,pdf,docx,xlsk,md',
            'attachment_url' => 'required_if:attachemt_type,external_link|url',
            'attachment_name' => 'required|string',
            'article_content' => 'required_if:attachment_type,article'
        ];
    }
}
