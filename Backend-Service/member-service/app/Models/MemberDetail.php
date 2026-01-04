<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MemberDetail extends Model
{
    use HasUuids;
    protected $fillable = [
        'id_user',
        'membership_status',
        'borrowing_count',
        'total_fine'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


}
