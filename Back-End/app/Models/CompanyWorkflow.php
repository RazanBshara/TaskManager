<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyWorkflow extends Model
{
    use HasFactory;

    public function Company(){
        return $this->belongsTo(Company::class);
    }

}
