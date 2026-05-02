<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_ruang', 'lokasi_penyimpanan_id'])]
class NamaRuang extends Model
{
    /** @use HasFactory<\Database\Factories\NamaRuangFactory> */
    use HasFactory,HasUuids;

    public function lokasiPenyimpanan()
    {
        return $this->belongsTo(LokasiPenyimpanan::class);
    }
}
