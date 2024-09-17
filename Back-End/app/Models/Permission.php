<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public function RoleGroupPermission(){
        return $this->hasMany(RoleGroupPermission::class);
    }

    public function RoleGroupCompanyPermissione(){
        return $this->hasMany(RoleGroupCompanyPermission::class);
    }
}
