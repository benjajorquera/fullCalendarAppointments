<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ["contact"];
    protected $casts = [
        'date' => 'datetime',
    ];
    protected $time = ["startTime"];
    
}
