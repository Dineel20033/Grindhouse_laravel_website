<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // Allow mass assignment for these fields (for CRUD operations)
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image'];

    /**
     * Define the relationship: A Product belongs to one Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}