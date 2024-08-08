<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'model',
        'category_id',
        'photo',
        'description',
        'price',
        'percentage',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function stocks(){
        return $this->hasMany(Stock::class);
    }
    // Product has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Product has many cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
