<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvents extends Model
{
     use HasFactory;
	protected $table = 'user_events'; 
	
	 public function events()
    {
        return $this->belongsTo(Events::class)->orderBy('name');
    }
	
	 public function user()
    {
        return $this->belongsTo(User::class)->orderBy('name');
    }
}
