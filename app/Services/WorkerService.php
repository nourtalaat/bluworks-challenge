<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class WorkerService
{
  private readonly float $max_distance;

  function __construct()
  {
    $this->max_distance = 2;
  }

  /** * Calculates the distance in KMs between two lat/long coordinate combinations
   *
   * @param $worker_id ID of the worker to register the clock-in for
   * @param $timestamp Timestamp of the request made to register the clock-in
   * @param $latitude Latitude sent by the worker for the place of the clock-in
   * @param $longitude Longitude sent by the worker for the place of the clock-in
   *
   * @return JsonResponse
   */
  public function clock_in(
    $worker_id,
    $timestamp,
    $latitude,
    $longitude
  )
  {
    if (!$this->ensure_worker_exists($worker_id)) {
      return response()->json(
        ['error' => 'Worker not found'],
        404
      );
    }

    $allowed_latitude_centerpoint = 30.0493558;
    $allowed_longitude_centerpoint = 31.2403066;

    $distance = $this->distance($latitude, $longitude, $allowed_latitude_centerpoint, $allowed_longitude_centerpoint);

    if ($distance > $this->max_distance) {
      return response()->json(
        ['error' => 'You must be in the vicinity of the workplace'],
        400
      );
    }

    return response()->json(
      [
        'clock_in' => [
          'id' => '123'
        ]
      ],
      201
    );
  }

  /** * Returns an array of clock-ins for the passed worker ID
   *
   * @param string $worker_id Worker ID to fetch the clock-ins for
   *
   * @return JsonResponse
   */
  public function get_clock_ins($worker_id)
  {
    if (!$this->ensure_worker_exists($worker_id)) {
      return response()->json(
        ['error' => 'Worker not found'],
        404
      );
    }
    
    return response()->json(
      [
        'clock_ins' => [
          [
            'id' => '1'
          ],
          [
            'id' => '2'
          ]
        ]
      ]
    );
  }

  /** * Checks whether the passed worker ID exists
   *
   * @param string $worker_id ID of the worker for whom we'd like to check
   *
   * @return boolean
   */
  private function ensure_worker_exists($worker_id)
  {
    return $worker_id === '123';
  }

  /** * Calculates the distance in KMs between two lat/long coordinate combinations
   *
   * @param integer $lat1 First latitude point
   * @param integer $lon1 First longitude point
   * @param integer $lat2 Second latitude point
   * @param integer $lon2 Second longitude point
   *
   * @return float
   */
  private function distance($lat1, $lon1, $lat2, $lon2)
  {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
      return 0;
    } else {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      return ($miles * 1.609344);
    }
  }
}