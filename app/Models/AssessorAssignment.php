<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessorAssignment extends Model
{
    protected $table = 'assessor_assignments';
    protected $primaryKey = 'id_assignment';

    protected $fillable = [
        'id_periode',
        'assessor_id',
        'assessee_id',
        'jenis_penilai',
        'status',
        'deadline',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(PeriodePenilaian::class, 'id_periode', 'id_periode');
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'assessor_id', 'id_karyawan');
    }

    public function assessee(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'assessee_id', 'id_karyawan');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_assignment', 'id_assignment');
    }
}
