<?php

namespace App\Services;

use App\Models\Slot;
use App\Models\Hold;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class SlotService {
	
    public function getSlots() {
		
		return Cache::flexible(
			key: 'slots',
			ttl: [
				5,  // Период "свежести" в сек
				15  // Общий жизненный цикл (свежесть + отсрочка) в сек
			],
			callback: function () {
				return 
					Slot::orderBy('id','ASC')
						->get();
			}
		);
    }
	
	public function holdHeld(Slot $slot) {
		
		if ($slot->remaining == 0) {
			return response()->json(['error' => 'Remaining 0 place'], 409, [], JSON_UNESCAPED_UNICODE);		
		}
		
		$hold = Hold::create([
			'slot_id' => $slot->id,
			'status' => 'held'
		]);

		return response()->json($slot, JsonResponse::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    
    }
	
	public function holdConfirmed(Hold $hold) {
		
		if ($hold->status != 'held') {
			return response()->json(['error' => 'Status already no held'], 422, [], JSON_UNESCAPED_UNICODE);		
		}
		
		if ($hold->slot->remaining == 0) {
			return response()->json(['error' => 'Remaining 0 place'], 409, [], JSON_UNESCAPED_UNICODE);		
		}
		
		DB::transaction(function() use ($hold) {
			
			$hold->update([
				'status' => 'confirmed'
			]);
			
			$hold->slot
				->decrement('remaining');
			
			Cache::forget('slots');
		});
		
		return response()->json('ok', JsonResponse::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
	
	public function holdCancelled(Hold $hold) {
		
		if ($hold->status == 'cancelled') {
			return response()->json(['error' => 'Status already cancelled'], 409, [], JSON_UNESCAPED_UNICODE);		
		}
		
		if ($hold->slot->remaining == $hold->slot->capacity) {
			return response()->json(['error' => 'Remaining already eq capacity'], 409, [], JSON_UNESCAPED_UNICODE);		
		}

		DB::transaction(function() use ($hold) {
			
			$hold->update([
				'status' => 'cancelled'
			]);
			
			$hold->slot
				->increment('remaining');
			
			Cache::forget('slots');
		});
		
		return response()->json('ok', JsonResponse::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    
    }
    
}