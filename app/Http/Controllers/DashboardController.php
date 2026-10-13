<?php

namespace App\Http\Controllers;

use App\Models\Category;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        if(request()->ajax() || request()->wantsJson()) {
            $categories = Category::all();

            return response()->json([
                'success'=> true,
                'categories'=> $categories
            ]);
        }

        $categories = Category::all()->where('status','active');

        return view('customer.dashboard', compact('categories'));
    }
}
