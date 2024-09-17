<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    public function Company(){
        return $this->belongsTo(Company::class);
    }

    public function Project(){
        return $this->hasMany(Project::class);
    }

    public function UserWorkspace(){
        return $this->hasMany(UserWorkspace::class);
    }



}
