<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionGroup extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_name', 'name')->orderBy('group_name');
    }

    public function activePermissions()
    {
        return $this->hasMany(Permission::class, 'group_name', 'name')->where('status', 1)->orderBy('group_name');
    }
}
