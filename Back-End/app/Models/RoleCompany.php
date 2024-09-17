<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleCompany extends Model
{
    use HasFactory;
    
    public function RoleGroupCompanyUser(){
        return $this->hasMany(RoleGroupCompanyUser::class);
    }

    public function RoleGroupCompanyPermission(){
        return $this->hasMany(RoleGroupCompanyPermission::class);
    }
}
