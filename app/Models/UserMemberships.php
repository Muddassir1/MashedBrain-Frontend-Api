<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMemberships extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        $this->hasMany(User::class, 'user_id');
    }
}
