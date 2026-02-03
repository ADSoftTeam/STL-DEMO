<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
	use HasFactory;
	
    public $timestamps = true;
	
    protected $fillable = [
        'capacity',
        'remaining',        
    ];
	
	protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
