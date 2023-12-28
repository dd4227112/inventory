<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'status',
        'shop_id',
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
