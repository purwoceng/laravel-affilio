<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartsOrder extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'id',
        'product_id',
        'affiliator_username',
        'quantity',
        'member_id',
        'publish',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
