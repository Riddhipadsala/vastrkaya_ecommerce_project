<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MainCategory::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $mainCategories = $query->orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'mainCategories' => $mainCategories
            ]);
        }

        return view('admin.pages.main-categories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:main_categories,name',
        ]);

        $mainCategory = MainCategory::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Main Category created successfully',
                'mainCategory' => $mainCategory
            ]);
        }

        return redirect()->back()->with('success', 'Main Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mainCategory = MainCategory::findOrFail($id);

        return response()->json([
            'success' => true,
            'mainCategory' => $mainCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mainCategory = MainCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:main_categories,name,' . $id,
        ]);

        $mainCategory->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Main Category updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Main Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mainCategory = MainCategory::findOrFail($id);
        $mainCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Main Category deleted successfully'
        ]);
    }
}

