<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SlotService;
use Illuminate\Http\JsonResponse;
use App\Models\Hold;

class HoldController extends Controller
{
	public function __construct(
        protected SlotService $slotService,
    ) {}
	
    public function holdConfirm(Hold $hold){
		
		$response = $this->slotService->holdConfirmed($hold);
		
		return $response;
		
	}
	
	public function holdDestroy(Hold $hold){
		
		$response = $this->slotService->holdCancelled($hold);
		
		return $response;
	}
}
