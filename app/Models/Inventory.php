<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color',
        'size',
        'quantity',
        'initial_quantity',
        'sold_quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'initial_quantity' => 'integer',
        'sold_quantity' => 'integer',
    ];

    /**
     * Get the product that owns the inventory
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get available quantity (quantity - sold_quantity)
     */
    public function getAvailableQuantityAttribute()
    {
        return max(0, $this->quantity - $this->sold_quantity);
    }
}



