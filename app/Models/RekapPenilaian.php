<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapPenilaian extends Model
{
    protected $table = 'rekap_penilaian';
    protected $primaryKey = 'id_rekap';

    protected $fillable = [
        'id_karyawan',
        'nilai_atasan',
        'nilai_peer',
        'nilai_bawahan',
        'nilai_self',
        'nilai_akhir',
        'grade',
        'keterangan',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
