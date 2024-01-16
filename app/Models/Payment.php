<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'amount',
        'date',
        'description',
        'user_id',
        'sale_id',
        'purchase_id',
        'status',
        'payment_method',
        'deleted_by'
    ];
    public function sale(){
        return $this->belongsTo(Sale::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by' );
    }
}
