<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'queue_number',
        'table_number',
        'order_type',
        'payment_method',
        'payment_proof',
        'payment_status',
        'order_status',
        'total_price',
    ];

    // Relasi: Order milik 1 User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Order punya banyak Item Menu
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}