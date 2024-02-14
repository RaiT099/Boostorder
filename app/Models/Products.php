<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    // public function scopeSearch($query, $keyword)
    // {
    //     return $query->where('title', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
       
    // }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
