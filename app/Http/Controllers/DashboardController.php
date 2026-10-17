<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
        $products = Product::all()->where('status',1);

        return view('customer.dashboard', compact('categories', 'products'));
    }
}
