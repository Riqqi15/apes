<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variabel extends Model
{
    protected $table = 'variabel';
    protected $primaryKey = 'id_variabel';

    protected $fillable = ['nama_variabel'];

    public function indikator(): HasMany
    {
        return $this->hasMany(Indikator::class, 'id_variabel', 'id_variabel');
    }
}
