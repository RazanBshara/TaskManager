<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleGroupPermission extends Model
{
    use HasFactory;

    public function RoleGroup(){
        return $this->belongsTo(RoleGroup::class);
    }

    public function Permission(){
        return $this->belongsTo(Permission::class);
    }

}
