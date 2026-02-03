<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini untuk diisi data
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'is_available',
    ];
}
