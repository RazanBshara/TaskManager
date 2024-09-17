<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function Unit(){
        return $this->belongsTo(Unit::class);
    }

    public function User(){
        return $this->hasMany(User::class);
    }

    public function ProjectDepartmentUnitSectionUser(){
        return $this->hasMany(ProjectDepartmentUnitSectionUser::class);
    }

}
