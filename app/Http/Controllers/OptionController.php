<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Option::query()->with('optionValues');

        if($request->ajax()){

            $search = $request->search;

            if($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('type', 'like', "%$search%")
                    ->orWhere('sort_order', 'like', "%$search%")
                    ->orwhereHas('optionValues', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                        ->orWhere('sort_order', 'like', "%$search%");
                    });
                });
            }

            $options = $query->orderby('sort_order', 'asc')->get();

            return response()->json([
                'success'=> true,
                'options' => $options
            ]);
        
        }

            return view('admin.pages.options.index');
        
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.options.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $optionValidate = $request->validate([
            'name' => 'required|string',
            'type' => 'string',
            'sort_order'=> 'integer'
        ]);

        $option = Option::create($optionValidate);

        foreach($request->option_values as $value){

            $image = $value['option_image'] ?? null;

            if($image){
                $fileName = $image->getClientOriginalName();
                
                $value['option_image'] = $image->storeAs('option_value_images', $fileName, 'public');
            }

            $optionValue = OptionValue::create([
                'option_id' => $option->id,
                'name' => $value['name'],
                'sort_order' => $value['sort_order'],
                'option_image' => $value['option_image'] ?? null
            ]);
        }

        if( $option && $optionValue ){
            return redirect()->route('admin.options.index')->with('success','Option & Values create successfully');
        }

        return redirect()->route('admin.options.index')->with('error','Option & Values create failed');
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        $option->load('optionValues');
        return view('admin.pages.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Option $option)
    {
        $optionValidate = $request->validate([
            'name' => 'required|string',
            'type' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $option->update($optionValidate);

        $keptValueIds = [];

        if ($request->has('option_values') && is_array($request->option_values)) {
            foreach ($request->option_values as $key => $value) {
                if (empty($value['name'])) {
                    continue;
                }

                $valueId = $value['id'] ?? null;
                $uploadedImage = null;

                if ($request->hasFile("option_values.{$key}.option_image")) {
                    $file = $request->file("option_values.{$key}.option_image");
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $uploadedImage = $file->storeAs('option_value_images', $fileName, 'public');
                }

                if ($valueId) {
                    $optionValue = OptionValue::where('id', $valueId)
                                              ->where('option_id', $option->id)
                                              ->first();
                    if ($optionValue) {
                        $updateData = [
                            'name' => $value['name'],
                            'sort_order' => $value['sort_order'] ?? 0,
                        ];

                        // If a new image was uploaded, replace the old one
                        if ($uploadedImage) {
                            if ($optionValue->option_image) {
                                Storage::disk('public')->delete($optionValue->option_image);
                            }
                            $updateData['option_image'] = $uploadedImage;
                        }

                        $optionValue->update($updateData);
                        $keptValueIds[] = $optionValue->id;
                    }
                } else {
                    // 2. CREATE NEW VALUE
                    $newValue = OptionValue::create([
                        'option_id' => $option->id,
                        'name' => $value['name'],
                        'sort_order' => $value['sort_order'] ?? 0,
                        'option_image' => $uploadedImage,
                    ]);
                    $keptValueIds[] = $newValue->id;
                }
            }
        }

        // 3. DELETE REMOVED VALUES & THEIR IMAGES
        $deletedValues = $option->optionValues()->whereNotIn('id', $keptValueIds)->get();
        foreach ($deletedValues as $deletedVal) {
            if ($deletedVal->option_image) {
                Storage::disk('public')->delete($deletedVal->option_image);
            }
            $deletedVal->delete();
        }

        return redirect()->route('admin.options.index')->with('success', 'Option & Values updated successfully');
    }
 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        $optionValue = $option->optionValues()->get();

        foreach($optionValue as $value) {
            if($value->option_image) {
                Storage::disk('public')->delete($value->option_image);
            }
        }
        
        $option = $option->delete();

        return response()->json([
            'success' => true,
            'message' => 'Option deleted successfully',
        ]);

    }
}
