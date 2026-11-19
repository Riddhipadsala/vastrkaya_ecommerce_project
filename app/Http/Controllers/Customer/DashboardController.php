<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\MainPoster;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {

        if (request()->ajax() || request()->wantsJson()) {
            $categories = Cache::tags('category')->remember('customer_ajax_category', now()->addMinutes(10), function () {
                return Category::where('status', 1)->get();
            });

            return response()->json([
                'success' => true,
                'categories' => $categories,
            ]);
        }

        $categories = Cache::tags(['category', 'main_category'])->remember('customer_category',now()->addMinutes(10), function() {
            return Category::with('main_category')->whereHas('main_category', function ($query) {
                        $query->where('status', 1);
                    })->where('status', 1)->get();
        });

        $products = Product::with('category.main_category')->where('status', 1)->whereHas('category', function ($query) {
                        $query->where('status', 1);
                    })->whereHas('category.main_category', function ($query) {
                        $query->where('status', 1);
                    })->inRandomOrder()
                        ->limit(10)->get();

        $coupons = Cache::tags('coupon')->remember('customer_coupon', now()->addMinutes(10), function () {
            return Coupon::where('status',1)->where('start_date','<=',now()->toDateString())->where('end_date','>=',now()->toDateString())->where('uses_total','>=', 'used_total')->first();
        });
        
        $setting = Cache::tags('setting')->remember('customer_setting', now()->addMinutes(10), function () {
            return Setting::get('minimum_order_amount')->first();
        });

        $mainPosters = Cache::tags('main_poster')->remember('customer_main_poster', now()->addMinutes(10), function () {
            return MainPoster::where('status',1)->get();
        });


        return view('customer.dashboard', compact('categories', 'products', 'coupons', 'setting', 'mainPosters'));
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
