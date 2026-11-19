<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

        if($request->brand){
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        $products = $query->with('category')->paginate(10);

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
                    'status'   => isset($option['status']) ? (int) $option['status'] : 1,
                ]);

                $optionValue = $option['values'] ?? [];
                $prices = $option['prices'] ?? [];

                if(is_array($optionValue)){
                    foreach($optionValue as $value){
           
                        ProductOptionValue::create([
                            'product_option_id'=> $productOption->id,
                            'option_value_id'=> (int) $value,
                            'option_id'=> (int) $option['option_id'],
                            'product_id'=> (int) $product->id,
                            // 'image'=> $value['image']
                            'price' => ($prices[$value] != '' && $prices[$value] != null) ? $prices[$value] : 0,
                        ]);
                    }
                }
            }
        }

        if($product){
            Cache::tags(['product','product_option','product_option_value'])->flush();
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
        $product->load([
            'productOptions' => function ($q) {
                $q->where('status', 1);
            },
            'productOptions.option.optionValues',
            'productOptionValues' => function ($q) {
                $q->where('status', 1);
            },
            'productOptionValues.optionValue',
            'category',
            'wishLists'
        ]);

        return view('customer.product-detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load([
            'productOptions',
            'productOptions.option.optionValues',
            'productOptionValues.optionValue',
            'category'
        ]);

        $categories = Category::all();
        $options = Option::with('optionValues')->get();

        return view('admin.pages.products.edit', compact(
            'product',
            'categories',
            'options'
        ));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validate = $request->validated();

        if ($request->hasFile('image')) {

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $validate['image'] = $file->storeAs(
                'product_images',
                $filename,
                'public'
            );
        }

        $product->update($validate);

        $submittedOptionIds = [];

        foreach ($request->input('options', []) as $option) {

            if (empty($option['option_id'])) {
                continue;
            }

            $optionId = (int) $option['option_id'];
            $submittedOptionIds[] = $optionId;

            $optionValues = $option['values'] ?? [];

            $prices = $option['prices'] ?? [];

            if (!is_array($optionValues)) {
                $optionValues = [];
            }

            $productOption = ProductOption::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'option_id' => $optionId,
                ],
                [
                    'status' => $option['status'] ?? 1,
                ]
            );

            if (empty($optionValues)) {
                ProductOptionValue::where('product_id', $product->id)
                    ->where('option_id', $optionId)
                    ->update(['status'=> 0]);

                continue;
            }

            ProductOptionValue::where('product_id', $product->id)
                ->where('option_id', $optionId)
                ->whereNotIn('option_value_id', $optionValues)
                ->update(['status'=> 0]);

            foreach ($optionValues as $value) {

                $valueId = (int) $value;

                $price = $prices[$value] ?? 0;

                if ($price === '' || $price === null) {
                    $price = 0;
                }

                ProductOptionValue::updateOrCreate(
                    [
                        'product_option_id' => $productOption->id,
                        'option_value_id' => $valueId,
                        'option_id' => $optionId,
                        'product_id' => $product->id,
                    ],
                    [
                        'status' => 1,
                        'price' => $price,
                    ]
                );
            }
        }

        if (!empty($submittedOptionIds)) {
            ProductOptionValue::where('product_id', $product->id)
                ->whereNotIn('option_id', $submittedOptionIds)
                ->update(['status' => 0]);
        }

        Cache::tags(['product','product_option_value','product_option'])->flush();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $deletedProduct = $product->delete();

        if($deletedProduct) {

            Cache::tags(['product','product_option_value','product_option'])->flush();

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
    
 
    public function optionStatusChange(Request $request) {
        
        $productOption = ProductOption::where('option_id', $request->optionId)->where('product_id', $request->productId)->first();

        if (!$productOption) {
            return response()->json([
                'success' => false,
                'message' => 'Product option not found'
            ], 404);
        }

        $statusUpdate = $productOption->update(['status'=> $request->status]);
        Cache::tags(['product_option'])->flush();
        if($statusUpdate) {
            return response()->json([
                'success'=> true,
                'productOption'=> $productOption
            ]);
        }
        else {
            return response()->json([
                'success'=> false,
            ]);
        }
    }
    
    public function deleteProductOption(Request $request) {

        $productOption = ProductOption::where('product_id', $request->product_id)->where('option_id', $request->option_id)->first();

        if ($productOption) {

            $deleteItem = $productOption->delete();
            Cache::tags(['product_option'])->flush();
            if($deleteItem) {
                return response()->json([
                    'success'=> true,
                    'message'=> 'product & option Deleted successfully'
                ]);
            }

            return response()->json([
                'success'=> false,
                'message'=> 'product & option not Deleted'
            ]);
        }
    
        return response()->json([
            'success'=> false,
            'message'=> 'product Not Founded !'
        ]);
    }

}
