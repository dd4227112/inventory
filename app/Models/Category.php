<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BasicModel
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
