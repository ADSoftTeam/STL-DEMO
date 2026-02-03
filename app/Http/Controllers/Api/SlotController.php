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
	
	/**
     * @api {get} api/slots/availability Получение списка доступных слотов
     * @apiVersion 0.0.1
     * @apiName Get slots
     * @apiGroup Slots
     *
     * @apiSuccessExample Success-Response
     *     HTTP/1.1 200 OK
     *     [
     *         {
     *             "id": 2,
     *             "capacity": 5,
     *             "remaining": 3
     *         },
     *         {
     *             "id": 3,
     *             "capacity": 6,
     *             "remaining": 1
     *         },
     *         {
     *             "id": 4,
     *             "capacity": 10,
     *             "remaining": 4
     *         },
	 *		....
	 *	  ]
     */	 
    public function getAvailabilitySlots(){
		
		$slots = $this->slotService->getSlots();
		
		return response()->json($slots, JsonResponse::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
		
	}
	
	/**
     * @api {post} api/slots/:id/hold Создание холда
     * @apiVersion 0.0.1
     * @apiName Hold create
     * @apiGroup Holds	 
	 * @apiHeader (Header) {UUID} Idempotency-Key ключ идемпотентности
	 * @apiParam {Numeric} id ID слота, на которое создается холд
     *
     * @apiSuccessExample Success-Response
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 2,
     *         "capacity": 5,
     *         "remaining": 3
     *     }
     *
	 * @apiErrorExample Error-Response
     *     HTTP/1.1 Status 409 Conflict
     *     {
     *         "error": "Remaining 0 place"
     *     }
	 *
	 *     HTTP/1.1 Status 404 Not Found
     *     {
     *         "error": "Record not found."
     *     }	 
	 *
     *     HTTP/1.1 Status 422 Unprocessable Content
     *     {
     *         "error": "Idempotency key previously used on different route (api/slots/1/hold)."
     *     }
	 *
	 *     HTTP/1.1 Status 422 Unprocessable Content
     *     {
     *         "error": "Idempotency key \"Idempotency-Key\" not found."
     *     }	 
     */	 
	public function setHold(Slot $slot){
		
		$response = $this->slotService->holdHeld($slot);
		
		return $response;
	}
}
