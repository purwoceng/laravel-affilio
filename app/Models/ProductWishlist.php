<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWishlist extends Model
{
    use HasFactory;
    protected $table = 'product_wishlist';
    protected $fillable = [
        'id',
        'product_id',
        'member_id',
        'publish',
    ];
    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
    ];
}
