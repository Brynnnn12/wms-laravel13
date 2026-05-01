<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_status'])]
class StatusBarang extends Model
{
    /** @use HasFactory<\Database\Factories\StatusBarangFactory> */
    use HasFactory,HasUuids;


}
