<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_assignment',
        'assessor_id',
        'id_karyawan',
        'id_indikator',
        'id_periode',
        'nilai',
        'tanggal_penilaian',
        'jenis_penilai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penilaian' => 'date',
        ];
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(AssessorAssignment::class, 'id_assignment', 'id_assignment');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator', 'id_indikator');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodePenilaian::class, 'id_periode', 'id_periode');
    }
}
