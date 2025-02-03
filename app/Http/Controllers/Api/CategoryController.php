<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Get all categories with hierarchy
    public function index()
    {
        // Fetch only categories where parent_id is NULL (i.e., parent categories)
        $parentCategories = categories::whereNull('parent_id')->get();
        return response()->json($parentCategories);

        
    }

    //get all the categories availabale
    public function allCategories()
    {
        $categories = categories::all(['category_id', 'category_name']);
        
        return response()->json($categories);
    }

    // Get a single categories with relationships
    public function show($id)
    {
        $categories = categories::with(['parent', 'children'])->find($id);
        if (!$categories) {
            return response()->json(['error' => 'categories not found'], 404);
        }
        return response()->json($categories);
    }

    // Create a new categories (protected route)
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,category_id'
        ]);

        $categories = categories::create([
            'category_name' => $request->category_name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'picture' => $request->picture,
            'created_by' => Auth::guard('api')->id(),
            'created_at' => now()
        ]);

        return response()->json($categories, 201);
    }

    // Update a categories (protected route)
    public function update(Request $request, $id)
    {
        $categories = categories::find($id);
        if (!$categories) {
            return response()->json(['error' => 'categories not found'], 404);
        }

        $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,category_name,'.$id.',category_id',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,category_id'
        ]);

        $categories->update($request->all());
        return response()->json($categories);
    }

    // Delete a categories (protected route)
    public function destroy($id)
    {
        $categories = categories::find($id);
        if (!$categories) {
            return response()->json(['error' => 'categories not found'], 404);
        }

        if ($categories->children()->exists()) {
            return response()->json(
                ['error' => 'Cannot delete categories with subcategories'], 
                400
            );
        }

        $categories->delete();
        return response()->json(['message' => 'categories deleted successfully']);
    }
}