<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|min:3|max:20|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $credentials['username'],
            'password' => Hash::make($credentials['password']),
        ]);
        Auth::login($user);
        return redirect()->route('tasks.index')->with('success', 'Account created successfully!');
    }
}
