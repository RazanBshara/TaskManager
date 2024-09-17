<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function UserTicket(){
        return $this->hasMany(UserTicket::class);
    }
    
    public function Process(){
        return $this->hasMany(Process::class);
    }
}
