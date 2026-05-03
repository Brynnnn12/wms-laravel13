<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_kondisi'])]
class KondisiBarang extends Model
{
    /** @use HasFactory<\Database\Factories\KondisiBarangFactory> */
    use HasFactory,HasUuids;

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kondisi_barang_id');
    }
}
