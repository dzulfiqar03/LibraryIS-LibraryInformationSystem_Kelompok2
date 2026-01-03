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
            'title'            => 'required|string',
            'authors'          => 'nullable|string',
            'isbn'             => 'nullable|string',
            'publisher'        => 'nullable|string',
            'publication_year' => 'nullable|integer|min:1800|max:2099',
            'category'         => 'nullable|string',
            'description'      => 'nullable|string',
            'pages'            => 'nullable|integer|min:1',
            'quantity'         => 'nullable|integer|min:1',
            'languages'        => 'nullable|string',
            'url_cover'        => 'nullable|string',
            'url_ebook'        => 'nullable|string',
            'status'           => 'nullable|string|in:available,borrowed,returned,overdue',
        ];
    }

    public function messages(): array
    {
        return [
            // Book basic info
            'title.required' => 'Title wajib diisi',
            'authors.string' => 'Authors harus berupa string',
            'isbn.string' => 'ISBN harus berupa string',
            'publisher.string' => 'Publisher harus berupa string',
            'publication_year.integer' => 'Publication year harus berupa angka',
            'publication_year.min' => 'Publication year minimal 1800',
            'publication_year.max' => 'Publication year maksimal 2099',
            'category.string' => 'Category harus berupa string',
            'description.string' => 'Description harus berupa string',
            'pages.integer' => 'Pages harus berupa angka',
            'pages.min' => 'Pages minimal 1',
            'quantity.integer' => 'Quantity harus berupa angka',
            'quantity.min' => 'Quantity minimal 1',
            'languages.string' => 'Languages harus berupa string',
            'url_cover.string' => 'URL cover harus berupa string',
            'url_ebook.string' => 'URL ebook harus berupa string',
            'status.string' => 'Status harus berupa string',
            'status.in' => 'Status harus salah satu dari: available, borrowed, returned, overdue',
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
