<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends BasicModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
