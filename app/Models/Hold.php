<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    public $timestamps = true;
	
    protected $fillable = [
        'slot_id',
        'status',        
    ];
	
	public function slot() {
		return $this->belongsTo(Slot::class);
	}
}
