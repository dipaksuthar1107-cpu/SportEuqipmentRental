<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'icon',
        'category',
        'quantity',
        'available',
        'condition',
        'deposit',
        'daily_rate',
        'max_days',
        'rating',
        'reviews',
        'rules',
        'features',
    ];

    protected $casts = [
        'rules' => 'array',
        'features' => 'array',
    ];
}
