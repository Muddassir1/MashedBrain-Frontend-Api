<?php

namespace App\Models;

use App\Notifications\NewUserRegistration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'country',
        'postal',
        'about',
        'category',
        'access_level',
        'avatar',
        'phone_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function get_membership_name()
    {
        return Membership::find($this->membership)->name;
    }

    public function get_access_level_name()
    {
        return AccessLevel::find($this->access_level)->name;
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class, 'user_id')->withDefault([
            'dark_mode' => 0,
            'notifications' => 0,
            'autoplay' => 0,
            'download_with_data' => 0,
            'delete_on_completion' => 0,
        ]);
    }

    public function membership()
    {
        return $this->belongsTo(UserMemberships::class, 'id', 'user_id');
    }

    public function categories()
    {
        return $this->belongsTo(UserCategories::class, 'id', 'user_id');
    }
}
