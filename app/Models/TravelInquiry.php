<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelInquiry extends Model
{
    use HasFactory;
	
    protected $fillable = [
        'username',
        'phone',
        'email',
        'destination',
        'travel_date',
    ];
}
