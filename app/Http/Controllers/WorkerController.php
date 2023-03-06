<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\WorkerService;

class WorkerController extends Controller
{
    private readonly WorkerService $worker_service;

    function __construct()
    {
        $this->worker_service = new WorkerService();
    }

  /** * Validates request payload and sends it to service method if it passes validation or returns a generic error message to thwart reverse engineering attempts
   *
   * @param Request $request User request object
   *
   * @return JsonResponse
   */
    public function clock_in(Request $request)
    {
      // Requests made with future timestamps or more than a minute ago are not allowed
        $now = time();
        $minimum_timestamp = $now - 60;

        $validator = Validator::make($request->all(), [
            'worker_id' => 'required|string',
            'timestamp' => "required|integer|between:$minimum_timestamp,$now",
            'latitude' => 'required|decimal:-90,90',
            'longitude' => 'required|decimal:-180,180'
        ]);

        if ($validator->fails()) {
            echo $validator->errors();
            return response()->json(
                ['error' => 'Invalid request'],
                400
            );
        }

        return $this->worker_service->clock_in(
            $request->worker_id,
            $request->timestamp,
            $request->latitude,
            $request->longitude
        );
    }

  /** * Ensures request has the worker_id query parameter and sends it to service method
   *
   * @param Request $request User request object
   *
   * @return JsonResponse
   */
    public function get_clock_ins(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['error' => 'Invalid request'],
                400
            );
        }

        return $this->worker_service->get_clock_ins($request->worker_id);
    }
}