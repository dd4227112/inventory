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
        'shop_id',
        'customer_id',
        'status',
        'uuid',
        'deleted_by'

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
    public function payment(){
        return $this->hasMany(Payment::class);
    }
    public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by' );
    }
}
