<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'stok_opname_id',
    'barang_id',
    'user_id',
    'qty_sistem',
    'qty_fisik',
    'selisih',
    'keterangan',
])]
class Penyesuaian extends Model
{
    use HasUuids;

    public function stokOpname()
    {
        return $this->belongsTo(StokOpname::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
