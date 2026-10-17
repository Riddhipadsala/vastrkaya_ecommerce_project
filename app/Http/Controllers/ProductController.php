<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if($request->id){
            $query->where('id', $request->id);
        }

        if($request->name){
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $products = $query->with('category')->get();

        if(request()->ajax()){
            return response()->json([
                'success'=> true,
                'products'=> $products
            ]);        
        }

        return view('admin.pages.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $options = Option::with('optionValues')->get();
        return view('admin.pages.products.create', compact('categories','options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validate = $request->validated();

        if($request->hasFile('image')){
        
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $validate['image'] = $file->storeAs('product_images', $filename, 'public');
        
        }

        $product = Product::create($validate);

        if($request->options){
            foreach($request->options as $option){
                $productOption = ProductOption::create([
                    'product_id'=> $product->id,
                    'option_id'=> (int) $option['option_id'],
                ]);

                $optionValue = $option['values'] ?? [];

                if(is_array($optionValue)){
                    foreach($optionValue as $value){
           
                        // if($value['image']){
                        //     $file = $value['image'];
                        //     $filename = $file->getClientOriginalName();
                        //     $value['image'] = $file->storeAs('product_option_images', $filename , 'public');
                        // }
           
                        $productOptionValue = ProductOptionValue::create([
                            'product_option_id'=> $productOption->id,
                            'option_value_id'=> (int) $value,
                            'option_id'=> (int) $option['option_id'],
                            'product_id'=> (int) $product->id,
                            // 'image'=> $value['image']
                        ]);
                    }
                }
            }
        }

        if($product){
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
        }else{
            return redirect()->back()->with('error', 'Failed to create product');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success'=> true,
            'product'=> $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['productOptions.option.optionValues', 'productOptionValues.optionValue', 'category']);
        $categories = Category::all();
        $options = Option::with('optionValues')->get();
        return view('admin.pages.products.edit', compact('product', 'categories', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validate = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validate['image'] = $file->storeAs('product_images', $filename, 'public');
        }

        $product->update($validate);

        // Delete existing relations and re-sync
        $product->productOptions()->delete();
        $product->productOptionValues()->delete();

        if ($request->options) {
            foreach ($request->options as $option) {
                if (empty($option['option_id'])) {
                    continue;
                }

                $productOption = ProductOption::create([
                    'product_id' => $product->id,
                    'option_id'  => (int) $option['option_id'],
                ]);

                $optionValue = $option['values'] ?? [];

                if (is_array($optionValue)) {
                    foreach ($optionValue as $value) {
                        ProductOptionValue::create([
                            'product_option_id' => $productOption->id,
                            'option_value_id'   => (int) $value,
                            'option_id'         => (int) $option['option_id'],
                            'product_id'        => (int) $product->id,
                            'image'             => '',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = $product->delete();

        if($product) {
            return response()->json([
                    'success'=> true,
            ]);
        }
        else {
            return response()->json([
                'success'=> false,
            ]);
        }
    }
}
