<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
	protected $table = 'events'; 

	 public function company()
    {
        return $this->belongsTo(Company::class)->orderBy('name');
    }
}
