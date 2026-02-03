<?php

use App\Http\Controllers\Api\SlotController;
use App\Http\Controllers\Api\HoldController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'slots'], function() {	
	Route::get('/availability', [SlotController::class, 'getAvailabilitySlots']);
	Route::post('/{slot}/hold', [SlotController::class, 'setHold'])->middleware(['idempotency']);
});

Route::group(['prefix' => 'holds'], function() {	
	Route::post('/{hold}/confirm', [HoldController::class, 'holdConfirm']);
	Route::delete('/{hold}', [HoldController::class, 'holdDestroy']);
});

Route::fallback(function() {
	return response()->json(['errors' => ['Not found API route']], 404);	
});


