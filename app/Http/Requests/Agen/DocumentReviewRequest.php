<?php

namespace App\Http\Requests\Agen;

use App\Models\DocumentUpload;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['admin', 'agen']) ?? false;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->input('status'),
            'review_notes' => $this->filled('review_notes')
                ? trim((string) $this->input('review_notes'))
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                DocumentUpload::STATUS_APPROVED,
                DocumentUpload::STATUS_REJECTED,
                DocumentUpload::STATUS_REVISION,
            ])],
            'review_notes' => [
                'nullable',
                'string',
                'max:1000',
                Rule::requiredIf(fn () => in_array($this->input('status'), [
                    DocumentUpload::STATUS_REJECTED,
                    DocumentUpload::STATUS_REVISION,
                ])),
            ],
        ];
    }
}

