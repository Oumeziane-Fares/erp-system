<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'description',
        'parent_id',
        'created_by',
        'created_at'
    ];

    protected $dates = ['created_at'];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // Products relationships
    public function parentRecursive()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id')
            ->with('parentRecursive');
    }

    // Get all ancestor categories
    public function ancestors()
    {
        return $this->parent ? $this->parent->ancestors()->prepend($this->parent) : collect();
    }

    // Get all descendant categories
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    // Get full category hierarchy for a product
    public function getFullHierarchyAttribute()
    {
        return $this->ancestors()->reverse()->push($this);
    }
}