<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'status',
        'shop_id'
    ];
    public function sale(){
        return $this->hasMany(Sale::class);
    }
    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
