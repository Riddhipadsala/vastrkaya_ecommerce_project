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


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'email'=> 'required',
            'password'=> 'required'
        ]);

        if(Auth::attempt($validate)) {
            $user = Auth::user();

            if($user->roles()->first()->name == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'You are logged in successfully');
            }
            
            return redirect()->route('dashboard')->with('success', 'You are logged in successfully');
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');

    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(Login $login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Login $login)
    {
        //
    }
}
