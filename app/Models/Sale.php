<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'grand_total',
        'date',
        'user_id',
        'customer_id',
        'status',
    ];
    public function sale_product(){
        return $this->hasMany(SaleProduct::class);
    }
    public function shop(){
        return $this->belongsTo(Shop::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
