<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function CompanyType(){
        return $this->belongsTo(CompanyType::class);
    }

    public function Department(){
        return $this->hasMany(Department::class);
    }

    public function Workspace(){
        return $this->hasMany(Workspace::class);
    }

    public function CompanyWorkflow(){
        return $this->hasMany(CompanyWorkflow::class);
    }

}

/*

    public function Company(){
        return $this->hasMany(User::class);
    }
    public function RestaurantType(){
        return $this->belongsTo(RestaurantType::class);
    }

    */
