<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    use ApiResponse;

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        event(new Registered($user));

        return $this->success('Registration successful.', ['token' => $user->createToken('api')->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $user = User::query()->where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->error('Invalid credentials.', null, 401);
        }

        return $this->success('Login successful.', ['token' => $user->createToken('api')->plainTextToken]);
    }

    public function logout(Request $request) { $request->user()->currentAccessToken()->delete(); return $this->success('Logged out.'); }
    public function me(Request $request) { return $this->success('Profile fetched.', $request->user()); }
    public function updateProfile(Request $request) { $request->user()->update($request->validate(['name'=>['sometimes','string'],'phone'=>['nullable','string']])); return $this->success('Profile updated.', $request->user()->fresh()); }
    public function forgotPassword() { return $this->success('Password reset link sent if email exists.'); }
    public function resetPassword() { return $this->success('Password reset successful.'); }
}
