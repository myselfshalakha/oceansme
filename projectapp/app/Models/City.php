<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
 use HasFactory;

    protected $fillable = [
    	'state_id',
        'name',
        'slug'
    ];

    public function state()
    {
        return $this->belongsTo(State::class)->orderBy('name');
    }
}
