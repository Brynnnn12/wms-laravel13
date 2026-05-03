<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['kode_jenis', 'jenis_barang'])]
class JenisBarang extends Model
{
    /** @use HasFactory<\Database\Factories\JenisBarangFactory> */
    use HasFactory ,HasUuids;

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jenis_barang_id');
    }
}
