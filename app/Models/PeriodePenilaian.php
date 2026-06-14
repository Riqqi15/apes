<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodePenilaian extends Model
{
    protected $table = 'periode_penilaian';
    protected $primaryKey = 'id_periode';

    protected $fillable = ['nama_periode', 'tanggal_mulai', 'tanggal_selesai', 'status'];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_periode', 'id_periode');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AssessorAssignment::class, 'id_periode', 'id_periode');
    }
}
