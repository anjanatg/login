<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function register(array $data): User
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => 'user',
            'is_active' => true,
        ]);
    }
    public function login(array $credentials, Request $request): string
    {
        if (! Auth::attempt($credentials)) { //login attempt fail aayal invalid return cheyum
            return 'invalid';
        }
        if (! Auth::user()->is_active) {
            $this->logout($request);
            return 'inactive';
        }
        $request->session()->regenerate();
        return 'ok';
    }

    public function dashboard(User $user): ?string
    {
        return match ($user->role) {
            'admin' => 'admin.dashboard',
            'user'  => 'user.dashboard',
            default => null,
        };
    }

    public function logout(Request $request): void
    {
        Auth::logout();  
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
