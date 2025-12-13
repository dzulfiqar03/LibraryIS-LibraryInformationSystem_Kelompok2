<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'id_user',
        'name',
        'username',
        'id_role',
        'telephone_number',
        'address',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'id_role', 'id');
    }


}
