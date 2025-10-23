<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use Notifiable;

  protected $table = 'users';

  protected $guarded = [];

  // ✅ Pastikan cast last_login_at ke datetime
  protected $casts = [
    'last_login_at' => 'datetime',
  ];

  // Relasi lain bisa ditambahkan
}
