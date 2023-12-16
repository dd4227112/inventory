<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Role extends BasicModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
