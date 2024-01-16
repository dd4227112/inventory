<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'deleted_by'
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by' );
    }
}
