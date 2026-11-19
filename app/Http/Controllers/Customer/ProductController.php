<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductOptionValue;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function productDetail(int $id)
    {
        $product = Cache::tags(['product','category', 'product_option','product_option_value'])->remember('productDetail_'.$id , now()->addMinutes(10), function() use($id) {
            return Product::with([
                'category',
                'productOptions' => function ($q) {
                    $q->where('status', 1);
                },
                'productOptions.option',
                'productOptionValues' => function ($q) {
                    $q->where('status', 1);
                },
                'productOptionValues.optionValue'
            ])->findOrFail($id);
        });

        $relatedProducts = Cache::tags(['product','category', 'main_category'])->remember('relatedProducts' , now()->addMinutes(10), function() use ($product) {
            return  Product::with('category.main_category')->whereHas('category', function ($q) { $q->where('status', 1); })
                        ->whereHas('category.main_category', function($q) { $q->where('status', 1); })
                        ->where('id', '!=', $product->id)
                        ->where('status', 1)
                        ->take(5)
                        ->get();
        });

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

        $cat_main_cat_pro = Cache::tags(['category','main_category','product'])->remember('productPage', now()->addMinutes(10), function () {
            return [
                'categories' => Category::with('main_category')->where('status',1)->get(),
        
                'main_categories' => MainCategory::where('status',1)->get(),
        
                'brands' => Product::with('category.main_category')->whereHas('category', function ($cat) { $cat->where('status', 1); })->whereHas('category.main_category', function($mc){ $mc->where('status', 1);})->where('status',1)->select('brand')->distinct()->pluck('brand')
            ];
        });
        
        $categories = $cat_main_cat_pro['categories'];
        $main_categories = $cat_main_cat_pro['main_categories'];
        $brands = $cat_main_cat_pro['brands'];
        return view('customer.products', compact('products','categories','main_categories','brands'));
    }

}
