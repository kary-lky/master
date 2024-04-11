<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class TravelInquiry extends Model
{
    use HasFactory;
	
    protected $fillable = [
        'title',
        'tags',
        'destination',
        'start_date',
        'end_date',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}