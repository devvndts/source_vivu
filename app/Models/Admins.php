<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
#use Illuminate\Database\Eloquent\Model;

class Admins extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'admins';

    protected $guarded = 'admin';

    protected $fillable = [
        'username', 'email', 'password', 'lastlogin', 'name', 'hienthi', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
