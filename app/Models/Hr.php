<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hr extends Model
{
    protected $table = 'hr';
    protected $primaryKey = 'id_hr';

    protected $fillable = ['nama_hr', 'jabatan', 'email', 'id_users'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
