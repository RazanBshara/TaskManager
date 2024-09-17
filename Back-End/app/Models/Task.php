<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Task extends Model
{
    use HasFactory;
    use NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'startdate',
        'enddate',
        'createdby',
        'type',
        'priority',
        'description',
        'projectid',
        'dependontask',
        'description',
    ];

    public function UserTask(){
        return $this->hasMany(UserTask::class);
    }
    public function Project(){
        return $this->belongsTo(Project::class);
    }

    public function Process(){
        return $this->hasMany(Process::class);
    }

    public function Timer(){
        return $this->hasMany(Timer::class);
    }
}
