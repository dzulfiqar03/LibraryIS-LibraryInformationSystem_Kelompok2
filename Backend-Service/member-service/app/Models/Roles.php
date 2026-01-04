<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'roles'
    ];

    public function user_detail()
    {
        return $this->hasMany(UserDetail::class, 'id_role', 'id');
    }
}
