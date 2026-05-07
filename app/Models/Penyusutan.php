<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'barang_id',
    'bulan',
    'tahun',
    'nilai_awal',
    'nilai_penyusutan',
    'akumulasi_penyusutan',
    'nilai_buku',
    'generated_at',
])]
class Penyusutan extends Model
{
    use HasUuids, HasFactory;

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
