<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->wantsJson() || $request->ajax()) {
            $query = Category::query();

            if($request->id){
                $query->where('id', $request->id);
            }

            if($request->name){
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->search) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name','like',"%{$search}%")
                        ->orWhere('description','like',"%{$search}%")
                        ->orWhere('status','like',"%{$search}%");
                });
            }
            
            $categories = $query->get();
            
            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        }
        return view('admin.pages.categories');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=> 'required|string|max:255',
            'description'=> 'required|string|max:255',
            'image' => 'required',
            'status' => 'nullable|in:active,inactive'
        ]);

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().$file->getClientOriginalName();
            $validate['image'] = $file->storeAs('categories',$imageName,'public');
        }

        $category = Category::create($validate);

        if($category) {
            return redirect()->back()->with('success', 'Category Created');
        }
        else {
            return redirect()->back()->with('error', 'Category Creation Failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name'=> 'required|string|max:255',
            'description'=> 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'image'=> 'nullable'
        ]);

        if($request->hasfile('image')) {
            $file = $request->file('image');
            $imageName = time().$file->getClientOriginalName();
            $validate['image'] = $file->storeAs('categories',$imageName,'public');
    
            if($category->image) {
                Storage::disk('public')->delete($category->image);
            }
        } else {
            unset($validate['image']);    
        }

        $category = $category->update($validate);

        if($category) {
            return response()->json([
                'success'=> true,
            ]);
        }
        else {
            return response()->json([
                'success'=> false
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $categories = $category->delete();

        if($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        if($categories) {
            return response()->json([
                'success'=> true,
                'categories'=> $categories
            ]);
        }

        return response()->json([
            'success'=> false,
            'message'=> 'Delete Failed'
        ]);
    }
}
