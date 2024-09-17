<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id', 'task_id', 'stopped_at', 'started_at'
        ];
    protected $dates = ['started_at', 'stopped_at'];
    protected $with = ['user'];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Task()
    {
        return $this->belongsTo(Task::class);
    }
    public function scopeMine($query)
    {
        return $query->whereUserId(auth()->user()->id);
    }
    public function scopeRunning($query)
    {
        return $query->whereNull('stopped_at');
    }
}
