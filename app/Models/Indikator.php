<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indikator extends Model
{
    protected $table = 'indikator';
    protected $primaryKey = 'id_indikator';

    protected $fillable = ['id_variabel', 'nama_indikator', 'nama_variabel_penilaian'];

    public function variabel(): BelongsTo
    {
        return $this->belongsTo(Variabel::class, 'id_variabel', 'id_variabel');
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'id_indikator', 'id_indikator');
    }
}
