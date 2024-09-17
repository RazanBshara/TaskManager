<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    public function Task(){
        return $this->belongsTo(Task::class);
    }

    public function ProcessType(){
        return $this->belongsTo(ProcessType::class);
    }

}
