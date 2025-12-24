<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\AuthResponseResources;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function Register(AuthRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create(
                [
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]
            );

            UserDetail::create([
                'id_user' => $user->id,
                'username' => $data['username'],
                'name' => $data['name'],
                'id_role' => $data['id_role'],
                'telephone_number' => $data['telephone_number'],
                'address' => $data['address'],
            ]);

            // Generate JWT token
            $token = auth()->login($user);

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate authentication token',
                ], 500);
            }

            return new AuthResponseResources([
                'auth' => 'Register',
                'token' => $token,
                'status' => 'Register Berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function login(AuthRequest $request)
    {

        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);
        if (!$token) {
            return new AuthResponseResources([
                'auth' => 'Login',
                'status' => 'Email Salah',
            ]);
        }

        return new AuthResponseResources([
            'auth' => 'Login',
            'token' => $token,
            'status' => 'Login Berhasil',

        ]);
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // meng-invalidate token saat ini
            return response()->json(['message' => 'Logout berhasil']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal logout atau token tidak valid'], 401);
        }
    }
}
