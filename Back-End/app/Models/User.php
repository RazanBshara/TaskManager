<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'phonenumber',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Company(){
        return $this->belongsTo(Company::class);
    }

    public function Department(){
        return $this->belongsTo(Department::class);
    }

    public function Unit(){
        return $this->belongsTo(Unit::class);
    }

    public function Section(){
        return $this->belongsTo(Section::class);
    }

    public function UserRoleGroup(){
        return $this->hasMany(UserRoleGroup::class);
    }

    public function UserRoleGroupCompany(){
        return $this->hasMany(UserRoleGroupCompany::class);
    }

    public function UserTask(){
        return $this->hasMany(UserTask::class);
    }

    public function Rule(){
        return $this->hasMany(Rule::class);
    }

    public function Reminder(){
        return $this->hasMany(Reminder::class);
    }

    public function Invitation(){
        return $this->hasMany(Invitation::class);
    }

    public function ProjectDepartmentUnitSectionUser(){
        return $this->hasMany(ProjectDepartmentUnitSectionUser::class);
    }


    public function Timer(){
       
        return $this->hasMany(Timer::class);
    }
    
    public function UserWorkspace(){
       
        return $this->hasMany(UserWorkspace::class);
    }

}
