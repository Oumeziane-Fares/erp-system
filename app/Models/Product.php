<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'subcategory_id',
    ];

    // Relationship with Category table
    public function category()
    {
        return $this->belongsTo(categories::class, 'category_id', 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(categories::class, 'subcategory_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Get full category hierarchy for the product
    public function getFullCategoryHierarchy()
    {
        $hierarchy = collect();
        $currentCategory = $this->subcategory ?? $this->category;

        while ($currentCategory) {
            $hierarchy->prepend($currentCategory);
            $currentCategory = $currentCategory->parent;
        }

        return $hierarchy;
    }
    // Relationship with Supplier (many-to-many through product_supplier pivot table)
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
                    ->withPivot('supplier_reference', 'quantity')
                    ->withTimestamps();
    }

    // Relationship with StockMovement
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    
}
