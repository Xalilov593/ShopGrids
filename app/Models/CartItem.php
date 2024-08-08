<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public  $fillable=[
        'cart_id',
        'product_id',
        'quantity'
    ];

    // CartItem belongs to a cart
    public function cart(){
        return $this->belongsTo(Cart::class);
    }


    // CartItem belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
