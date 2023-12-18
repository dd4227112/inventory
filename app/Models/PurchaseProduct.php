<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseProduct extends BasicModel

{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'product_id',
        'date',
        'quantity',
        'price',
        'total',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
}
