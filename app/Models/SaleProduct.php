<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleProduct extends BasicModel
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'date',
        'quantity',
        'price',
        'total',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
}
