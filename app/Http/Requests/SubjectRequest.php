<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'semester' => 'required|in:summer,winter',
            'year' => 'required|integer|min:1|max:3',
            'studies_type' => 'required|in:bachelors,masters',
            'teacher_id' => 'required|exists:users,id',
            'teaching_assistant_id' => 'nullable|exists:users,id',
            'prerquisite_subject_id' => 'nullable|exists:subjects,id',
            'credits' => 'required|integer|max:10|min:1',
            'description' => 'required|string',
            'grading_guide' => 'nullable|file|mimes:txt,docx,pdf,xlsx,csv,md,rtf|max:5120',
            'curriculum_overview' => 'nullable|file|mimes:txt,docx,pdf,xlsx,csv,md,rtf|max:5120'
        ];
    }
}
