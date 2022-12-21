<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMemberships extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at','id','user_id'];
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function details(){
        return $this->belongsTo(Membership::class,'membership_id','id');
    }
}
