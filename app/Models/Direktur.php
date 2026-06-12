<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Direktur extends Model
{
    protected $table = 'direktur';
    protected $primaryKey = 'id_direktur';

    protected $fillable = ['nama_direktur', 'jabatan', 'email', 'id_users'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
