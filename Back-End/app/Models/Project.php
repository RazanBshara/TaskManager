<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function Workspace(){
        return $this->belongsTo(Workspace::class);
    }

    public function ProjectDepartmentUnitSectionUser(){
        return $this->hasMany(ProjectDepartmentUnitSectionUser::class);
    }

    public function Task(){
        return $this->hasMany(Task::class);
    }
}
