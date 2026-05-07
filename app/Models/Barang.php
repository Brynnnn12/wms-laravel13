<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'kode_barang',
    'nama_barang',
    'jenis_barang_id',
    'jml_barang',
    'harga_satuan',
    'harga_total',
    'masa_penyusutan',
    'nilai_residual',
    'label',
    'status_barang_id',
    'kondisi_barang_id',
    'nama_ruang_id',
    'tahun_anggaran',
    'tanggal_perolehan',
])]
class Barang extends Model
{
    use HasUuids, HasFactory;

    protected $casts = [
        'tanggal_perolehan' => 'date',
    ];

    public function jenisBarang(): BelongsTo
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function statusBarang(): BelongsTo
    {
        return $this->belongsTo(StatusBarang::class);
    }

    public function kondisiBarang(): BelongsTo
    {
        return $this->belongsTo(KondisiBarang::class);
    }

    public function namaRuang(): BelongsTo
    {
        return $this->belongsTo(NamaRuang::class);
    }

    public function penyusutans(): HasMany
    {
        return $this->hasMany(Penyusutan::class);
    }
}
