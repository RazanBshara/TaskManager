<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTicket extends Model
{
    use HasFactory;
    
    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Ticket(){
        return $this->belongsTo(Ticket::class);
    }
    
}
