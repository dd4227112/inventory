<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permissions extends BasicModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    public function user_permission()
    {
        return $this->hasMany(UserPermissions::class);
    }
}



