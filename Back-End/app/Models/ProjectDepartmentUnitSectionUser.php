<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDepartmentUnitSectionUser extends Model
{
    use HasFactory;

    public function Department(){
        return $this->belongsTo(Department::class);
    }

    public function Unit(){
        return $this->belongsTo(Unit::class);
    }

    public function Section(){
        return $this->belongsTo(Section::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Project(){
        return $this->belongsTo(Project::class);
    }
}
