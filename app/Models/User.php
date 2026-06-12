<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_users';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'email',
        'password',
        'akses_user',
    ];

    protected $hidden = [
        'password',
    ];

    public function hr(): HasOne
    {
        return $this->hasOne(Hr::class, 'id_users', 'id_users');
    }

    public function direktur(): HasOne
    {
        return $this->hasOne(Direktur::class, 'id_users', 'id_users');
    }

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class, 'id_users', 'id_users');
    }
}
