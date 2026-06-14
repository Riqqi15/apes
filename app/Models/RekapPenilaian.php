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
        'id_periode',
        'nilai_atasan',
        'nilai_peer',
        'nilai_bawahan',
        'nilai_self',
        'nilai_akhir',
        'grade',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'nilai_atasan' => 'float',
            'nilai_peer' => 'float',
            'nilai_bawahan' => 'float',
            'nilai_self' => 'float',
            'nilai_akhir' => 'float',
        ];
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodePenilaian::class, 'id_periode', 'id_periode');
    }
}
