<?php

namespace App\Models;

use App\Notifications\TransactionNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function ($transaction) {
            Notification::send(User::where('access_level', 3)->get(), new TransactionNotification($transaction));
        });
    }
}
