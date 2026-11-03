<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        if (request()->ajax() || request()->wantsJson()) {
            $categories = Category::where('status', 1)->get();

            return response()->json([
                'success' => true,
                'categories' => $categories,
            ]);
        }

        $categories = Category::with('main_category')->whereHas('main_category', function ($query) {
            $query->where('status', 1);
        })->where('status', 1)->get();

        $products = Product::with('category.main_category')->where('status', 1)->whereHas('category', function ($query) {
            $query->where('status', 1);
        })->whereHas('category.main_category', function ($query) {
            $query->where('status', 1);
        })->inRandomOrder()
            ->limit(10)->get();

        $coupons = Coupon::where('status',1)->where('start_date','<=',now()->toDateString())->where('end_date','>=',now()->toDateString())->where('uses_total','>=', 'used_total')->first();

        return view('customer.dashboard', compact('categories', 'products', 'coupons'));
    }

    public function mainSearch(Request $request) {

        $search = $request->search;
        
        if($search) {
            $products = Product::with('category.main_category')->where('status', 1)->whereHas('category', function ($query) {
                $query->where('status', 1);
            })->whereHas('category.main_category', function ($query) {
                $query->where('status', 1);
            })
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            })->get();
            
            $categories = Category::with('main_category')->whereHas('main_category', function ($query) {
                $query->where('status', 1);
            })->where('status',1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })->get();
            
            $coupons = Coupon::where('code', 'like', "%{$search}%")->Orwhere('coupon_name',"%{$search}%")->get();

            return response()->json([
                'success' => true,
                'products' => $products,
                'categories' => $categories,
                'coupons' => $coupons,
            ]);
        }
    }
}
