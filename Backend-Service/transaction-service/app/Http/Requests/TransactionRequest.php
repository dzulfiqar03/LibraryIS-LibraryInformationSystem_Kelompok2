<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_member' => 'required|string',
            'books' => 'required|array|min:1',
            'books.*.id_book' => 'required|string',
            'books.*.quantity' => 'integer|min:1',
            'books.*.price' => 'numeric|min:0',
            'transaction_date' => 'required|date'
        ];
    }

    public function messages(): array
    {
        return [
            'id_member.required' => 'ID Member wajib diisi',
            'books.required' => 'Minimal satu buku wajib dipilih',
            'books.*.id_book.required' => 'ID Buku wajib diisi',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi'
        ];
    }

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
