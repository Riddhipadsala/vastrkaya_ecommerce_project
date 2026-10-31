<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        if(request()->ajax() || request()->wantsJson()) {
            $categories = Category::where('status',1)->get();

            return response()->json([
                'success'=> true,
                'categories'=> $categories
            ]);
        }

        $categories = Category::where('status',1)->get();
        
        $products = Product::with('category')->where('status',1)->whereHas('category',function($query){
            $query->where('status',1);
        })->limit(10)->get();

        $coupons = Coupon::all();
        
        return view('customer.dashboard', compact('categories', 'products','coupons'));
    }

}
