<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationTokens extends Model
{
    use HasFactory;

    protected $table = "user_notif_tokens";
    public $primaryKey = null;
    public $timestamps = false;
    protected $fillable = ['user_id','token'];
}
