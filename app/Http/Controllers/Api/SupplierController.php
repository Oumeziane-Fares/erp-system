<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Get all suppliers
    public function index()
    {
        $suppliers = Supplier::with('products')->get();
        return response()->json($suppliers);
    }

    // Get a single supplier
    public function show($id)
    {
        $supplier = Supplier::with('products')->find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
        return response()->json($supplier);
    }

    // Create a new supplier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'contact_info' => 'nullable|string',
        ]);

        $supplier = Supplier::create($request->all());
        return response()->json($supplier, 201);
    }

    // Update a supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string',
            'contact_info' => 'nullable|string',
        ]);

        $supplier->update($request->all());
        return response()->json($supplier);
    }

    // Delete a supplier
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }

        $supplier->delete();
        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}