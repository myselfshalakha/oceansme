<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function cities()
    {
        return $this->hasMany(City::class)->orderBy('name');
    }
	
	
    public function country()
    {
        return $this->belongsTo(Country::class)->orderBy('name');
    }
}
