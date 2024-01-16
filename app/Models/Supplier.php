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
        'deleted_by'
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
    public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by' );
    }
}
