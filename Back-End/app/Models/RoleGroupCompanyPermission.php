<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroupCompanyPermission extends Model
{
    use HasFactory;

    public function RoleGroupCompany(){
        return $this->belongsTo(RoleGroupCompany::class);
    }

    public function Permission(){
        return $this->belongsTo(Permission::class);
    }

}
