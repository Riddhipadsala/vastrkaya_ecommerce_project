<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index() {
        
        $products = Product::with('category')->get();
        $productCount = Product::count();
        $categories = Category::all();
        $categoryCount = Category::count();
        $options = Option::all();
        $optionCount = Option::count();
        $stock = Product::sum('stock');
        $UrgentStock = Product::where('stock','<=',5)->get();

        if(request()->ajax()) {
            return response()->json([
                'products' => $products,
                'productCount' => $productCount,
                'categories' => $categories,
                'categoryCount' => $categoryCount,
                'options' => $options,
                'optionCount' => $optionCount,
                'stock' => $stock,
                'UrgentStock'=> $UrgentStock
            ]);
        }
        return view('admin.dashboard', compact('products', 'categories', 'options', 'stock'));
    }
}
