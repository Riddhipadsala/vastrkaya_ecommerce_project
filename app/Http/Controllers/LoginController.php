<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function register(Request $request){

        $data = $request->validate([
            'phone' => 'required|string|max:10|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if($user->roles()->exists()) {
            return redirect()->route('login')->with('error', 'You are already registered');
        }
        else {
            $user->assignRole('customer');
        }

        return redirect()->route('login')->with('success', 'You are registered successfully');

    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'email'=> 'required',
            'password'=> 'required'
        ]);

        if(Auth::attempt($validate)) {
            $user = Auth::user();

            $role = $user->roles()->first();

            if($role && $role->name == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'You are logged in successfully');
            }
            
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');

    }

    
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

}
