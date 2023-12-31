<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'shop_id', // the shop where this product belong
        'code',
        'name',
        'quantity',
        'description',
        'user_id', // user who created/ add this product
        'price',
        'cost',
        'unit_id',
        'category_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function sale_product(){
        return $this->hasMany(SaleProduct::class);
    }
    public function purchase_product(){
        return $this->hasMany(PurchaseProduct::class);
    }
}
