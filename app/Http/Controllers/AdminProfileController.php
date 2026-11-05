<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkUser = Auth::user()->roles()->first();

        if($checkUser->name == 'admin') {
            return view('admin.pages.profile');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $adminProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {dd('gfdgd');
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'email' => 'unique:users,email,'.Auth::user()->id,
            'phone' => 'max:10|unique:users,phone,'.Auth::user()->id,
            'password' => 'confirmed|min:6',
        ]);

        $user = User::findOrFail(Auth::id());

        if ($request->filled('password')) {
            $validate['password'] = Hash::make($request->password);
        }

        $user->update($validate);

        return redirect()->back()->with(
            'success',
            'Admin profile updated successfully'
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
    }
}
