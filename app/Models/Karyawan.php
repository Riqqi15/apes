<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_users',
        'nip',
        'nama_lengkap',
        'no_hp',
        'jabatan',
        'tanggal_lahir',
        'alamat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_karyawan', 'id_karyawan');
    }

    public function rekapPenilaian(): HasMany
    {
        return $this->hasMany(RekapPenilaian::class, 'id_karyawan', 'id_karyawan');
    }
}
