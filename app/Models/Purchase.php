<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends BasicModel
{
    use HasFactory;
    
    protected $fillable = [
        'reference',
        'grand_total',
        'date',
        'user_id',
        'shop_id',
        'supplier_id',
        'status',
    ];

    public function purchase_product(){
        return $this->hasMany(PurchaseProduct::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    } 
    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
