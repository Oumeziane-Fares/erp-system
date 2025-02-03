<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact_info',
    ];

    // Relationship with Product (many-to-many through product_supplier pivot table)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
                    ->withPivot('supplier_reference', 'quantity')
                    ->withTimestamps();
    }

    // Relationship with StockMovement
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
