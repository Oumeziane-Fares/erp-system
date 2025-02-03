<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    // Add stock
    public function addStock(Request $request, $productId, $supplierId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Update the product_supplier pivot table (quantity)
        $product->suppliers()->updateExistingPivot($supplierId, [
            'quantity' => DB::raw('quantity + ' . $request->quantity),
        ]);
        /** @var Guard $auth */
        $auth = auth();
        // Log the stock movement
        StockMovement::create([
            'product_id' => $productId,
            'supplier_id' => $supplierId,
            'quantity' => $request->quantity,
            'movement_type' => 'addition',
            'reference' => $request->reference,
            'notes' => $request->notes,
            'user_id' => $auth->id(),
        ]);

        return response()->json(['message' => 'Stock added successfully'], 200);
    }

    // Remove stock
    public function removeStock(Request $request, $productId, $supplierId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Check if enough stock is available
        $currentQuantity = $product->suppliers()->where('supplier_id', $supplierId)->first()->pivot->quantity;
        if ($currentQuantity < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        // Update the product_supplier pivot table (quantity)
        $product->suppliers()->updateExistingPivot($supplierId, [
            'quantity' => DB::raw('quantity - ' . $request->quantity),
        ]);
        /** @var Guard $auth */
        $auth = auth();
        // Log the stock movement
        StockMovement::create([
            'product_id' => $productId,
            'supplier_id' => $supplierId,
            'quantity' => $request->quantity,
            'movement_type' => 'subtraction',
            'reference' => $request->reference,
            'notes' => $request->notes,
            'user_id' =>  $auth->id(),
        ]);

        return response()->json(['message' => 'Stock removed successfully'], 200);
    }
}