<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function Company(){
        return $this->belongsTo(Company::class);
    }

    public function Unit(){
        return $this->hasMany(Unit::class);
    }

    public function User(){
        return $this->hasMany(User::class);
    }

    public function ProjectDepartmentUnitSectionUser(){
        return $this->hasMany(ProjectDepartmentUnitSectionUser::class);
    }
    
}
