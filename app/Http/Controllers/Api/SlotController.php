<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SlotService;
use Illuminate\Http\JsonResponse;
use App\Models\Slot;

class SlotController extends Controller
{
	public function __construct(
        protected SlotService $slotService,
    ) {}
	
    public function getAvailabilitySlots(){
		
		$slots = $this->slotService->getSlots();
		
		return response()->json($slots, JsonResponse::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
		
	}
	
	public function setHold(Slot $slot){
		
		$response = $this->slotService->createHold($slot);
		
		return $response;
	}
}
