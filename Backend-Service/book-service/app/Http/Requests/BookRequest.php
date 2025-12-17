<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookRequest extends FormRequest
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
            'title'    => 'required|string',
            'authors'    => 'nullable|string',
        'languages'  => 'nullable|string',
        'url_cover'  => 'nullable|string',
        'url_ebook'  => 'nullable|string',
        'status'     => 'nullable|string',

        ];
    }

    public function messages(): array
    {
        return [
            // REGISTER
            'title.required' => 'Title wajib diisi',
            'authors.required' => 'Authors wajib diisi',
            'languages.required' => 'Bahasa wajib diisi',
            'url_cover.string' => 'URL wajib String',
            'url_ebook.string' => 'URL wajib String',
            'status.required' => 'Status wajib diisi',
        ];
    }


    // ⬇️ TARUH DI SINI
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
