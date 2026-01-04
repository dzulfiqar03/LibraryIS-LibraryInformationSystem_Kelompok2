<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\Routing\Route;

class AuthRequest extends FormRequest
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
        if ($this->routeIs('register')) {
            return [
                'username'    => 'required|string',
                'name'    => 'required|string',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'id_role' => 'required',
                'telephone_number' => 'required|string|min:10',
                'address' => 'required|string',
            ];
        } else {
            return [
                'email' => 'required|string',
                'password' => 'required|string',
            ];
        }
    }

    public function messages(): array
{
    return [
        // REGISTER
        'username.required' => 'Username wajib diisi',
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'telephone_number.required' => 'Nomor telepon wajib diisi',
        'telephone_number.min' => 'Nomor telepon minimal 10 digit',
        'address.required' => 'Alamat wajib diisi',
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
