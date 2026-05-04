<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'tanggal_so',
    'nama_ruang_id',
    'keterangan',
])]
class StokOpname extends Model
{
    use HasUuids;

    protected $casts = [
        'tanggal_so' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function namaRuang()
    {
        return $this->belongsTo(NamaRuang::class);
    }

    public function penyesuaian()
    {
        return $this->hasMany(Penyesuaian::class);
    }
}
