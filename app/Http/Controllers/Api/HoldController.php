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
	
	/**
     * @api {post} api/holds/:id/confirm Подтверждение холда
     * @apiVersion 0.0.1
     * @apiName Hold confirm
     * @apiGroup Holds	 
	 * @apiParam {Numeric} id ID слота, на которое создается холд
     *
     * @apiSuccessExample Success-Response
     *     HTTP/1.1 200 OK
     *     ok
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
     *         "error": "Status already no held"
     *     }
	 *	 
	 */	 
    public function holdConfirm(Hold $hold){
		
		$response = $this->slotService->holdConfirmed($hold);
		
		return $response;
		
	}
	
	/**
     * @api {delete} api/holds/:id Отмена холда
     * @apiVersion 0.0.1
     * @apiName Hold cancelled
     * @apiGroup Holds	 	 
	 * @apiParam {Numeric} id ID отменяемого холда
     *
     * @apiSuccessExample Success-Response
     *     HTTP/1.1 200 OK
     *     ok
     *
	 * @apiErrorExample Error-Response
     *     HTTP/1.1 Status 409 Conflict
     *     {
     *         "error": "Status already cancelled"
     *     }
	 *
	 *     HTTP/1.1 Status 404 Not Found
     *     {
     *         "error": "Record not found."
     *     }	 
	 *
     *     HTTP/1.1 Status 409 Conflict
     *     {
     *         "error": "Remaining already eq capacity."
     *     }
	 *	 
	 */	 
	public function holdDestroy(Hold $hold){
		
		$response = $this->slotService->holdCancelled($hold);
		
		return $response;
	}
}
