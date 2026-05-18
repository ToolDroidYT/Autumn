<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! str_ends_with(strtolower($credentials['email']), '@umindanao.edu.ph')) {
            return back()->withErrors(['email' => 'Use your @umindanao.edu.ph email.'])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('toast', 'Signed in.');
        }

        return back()->withErrors(['email' => 'Invalid university email or password.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', function ($attribute, $value, $fail) {
                if (! str_ends_with(strtolower($value), '@umindanao.edu.ph')) {
                    $fail('Use your @umindanao.edu.ph email.');
                }
            }],
            'program' => ['required', Rule::in(['DCE', 'IT', 'CS', 'CSIT/DCE', 'CODES'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $role = Role::query()->where('name', 'student')->firstOrFail();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'program' => $data['program'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('toast', 'Account created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('toast', 'Signed out.');
    }
}
