<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroupCompany extends Model
{
    use HasFactory;

    public function UserRoleGroupCompany(){
        return $this->hasMany(UserRoleGroupCompany::class);
    }

    public function RoleGroupCompanyPermission(){
        return $this->hasMany(RoleGroupCompanyPermission::class);
    }
}
