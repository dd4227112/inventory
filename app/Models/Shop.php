<?php

namespace App\Models;
use \App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shop extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'description',
        'location'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }

}
