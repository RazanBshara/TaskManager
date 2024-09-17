<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleGroup extends Model
{
    use HasFactory;
    
    public function User(){
        return $this->belongsTo(User::class);
    }

    public function RoleGroup(){
        return $this->belongsTo(RoleGroup::class);
    }
}
