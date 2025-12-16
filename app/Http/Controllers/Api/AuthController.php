<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // 1. REGISTER
    public function register(Request $request)
    {
        // 1. Update Validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20', // <--- Tambahan
            'password' => 'required|string|min:8|confirmed', // <--- Tambah 'confirmed' biar ngecek password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Masukkan data ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // <--- Tambahan
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role member
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // 2. LOGIN
    public function login(Request $request)
    {
        // Cek kredensial
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau Password salah'
            ], 401);
        }

        // Ambil data user
        $user = User::where('email', $request->email)->firstOrFail();

        // Buat Token (Hapus token lama biar bersih, opsional)
        // $user->tokens()->delete(); 
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kirim response JSON ke Flutter
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token, // <--- INI YANG DIBUTUHKAN FLUTTER
        ]);
    }

    // 3. LOGOUT (Opsional, buat nanti)
    public function logout(Request $request)
    {
        // Hapus token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
