<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductOptionValue;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productDetail(int $id)
    {
        $query = Product::with([
            'category',
            'productOptions' => function ($q) {
                $q->where('status', 1);
            },
            'productOptions.option',
            'productOptionValues' => function ($q) {
                $q->where('status', 1);
            },
            'productOptionValues.optionValue'
        ]);

        $product = $query->findOrFail($id);

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(5)
            ->get();

        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }
    
    public function productsPage(Request $request) 
    {
        $query = Product::with('category.main_category')->where('status',1)->whereHas('category',function($query){
            $query->where('status',1);
        })->whereHas('category.main_category',function ($query) {
            $query->where('status',1);
        });

        if($request->has('filters')) {
            $filters = $request->filters;
           
            $query->when(!empty($filters['main_category_id']), function ($q) use ($filters) {
                $q->whereHas('category', function ($qu) use ($filters) {
                    $qu->whereIn('main_category_id', $filters['main_category_id']);
                });
            });

            $query->when(!empty($filters['category_id']), function ($q) use ($filters) {
                $q->whereIn('category_id', $filters['category_id']);
            });

            $query->when(!empty($filters['brand']), function ($q) use ($filters) {
                $q->whereIn('brand', $filters['brand']);
            });

            $query->when(!empty($filters['price']), function ($q) use ($filters) {
                $price = explode('-', $filters['price'][0]);
               
                if ($price[1] == 'above') {
                    $q->where('price', '>=', $price[0]);
                } else {
                    $q->whereBetween('price', $price);
                }
            });

            $query->when(!empty($filters['discount_percentage']), function ($q) use ($filters) {
                $discount_percentage = explode('-', $filters['discount_percentage'][0]);
                $q->whereBetween('discount_percentage', $discount_percentage);
            });

        }

        if($request->main_category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('main_category_id', $request->main_category);
            });
        }

        if($request->category) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(10);
        
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'=> true,
                'products'=> $products
            ]); 
        }
        
        $categories = Category::with('main_category')->where('status',1)->get();

        $main_categories = MainCategory::where('status',1)->get();

        $brands = Product::select('brand')->distinct()->get();
        
        return view('customer.products', compact('products','categories','main_categories','brands'));
    }

}
