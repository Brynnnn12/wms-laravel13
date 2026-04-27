<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['name', 'guard_name'])]
class Permission extends SpatiePermission
{
}
