<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id'
    ];

    // Cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cart has many cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

}
