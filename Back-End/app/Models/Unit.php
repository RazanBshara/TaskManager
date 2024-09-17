<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    public function Department(){
        return $this->belongsTo(Department::class);
    }

    public function User(){
        return $this->hasMany(User::class);
    }

    public function ProjectDepartmentUnitSectionUser(){
        return $this->hasMany(ProjectDepartmentUnitSectionUser::class);
    }

    
}
