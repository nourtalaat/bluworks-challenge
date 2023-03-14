<?php

namespace App\Services;

use App\Enum\Clock\ClockingType;
use App\Exceptions\ResourceNotFound;
use App\Models\Clock;
use App\Models\Worker;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WorkerService
{
  private readonly float $max_distance;

  function __construct()
  {
    // Should be configurable
    $this->max_distance = 2;
  }

  /** * Calculates the distance in KMs between two lat/long coordinate combinations
   *
   * @param $worker_id ID of the worker to register the clock-in for
   * @param $timestamp Timestamp of the request made to register the clock-in
   * @param $latitude Latitude sent by the worker for the place of the clock-in
   * @param $longitude Longitude sent by the worker for the place of the clock-in
   * 
   * @throws ResourceNotFound If the worker does not exist
   * @throws BadRequestException If the distance between coordinates exceeds the allowed maximum
   * @return Clock
   */
  public function clock_in(
    $worker_id,
    $timestamp,
    $latitude,
    $longitude
  )
  {
    if (!$this->does_worker_exist($worker_id)) {
      throw new ResourceNotFound($worker_id);
    }

    // Should be fetched as per the Worker's workplace's coordinates
    $allowed_latitude_centerpoint = 30.0493558;
    $allowed_longitude_centerpoint = 31.2403066;

    $distance = $this->calculate_distance($latitude, $longitude, $allowed_latitude_centerpoint, $allowed_longitude_centerpoint);

    if ($distance > $this->max_distance) {
      throw new BadRequestException('You must be in the vicinity of the workplace');
    }

    $clock_in = Clock::create(
      array(
        'worker_id' => $worker_id,
        'timestamp' => $timestamp,
        'longitude' => $longitude,
        'latitude' => $latitude,
        'type' => ClockingType::IN->name,
      )
    );


    return $clock_in;
  }

  /** * Returns an array of clock-ins for the passed worker ID
   *
   * @param string $worker_id Worker ID to fetch the clock-ins for
   * 
   * @throws ResourceNotFound If the worker does not exist
   * @return Clock[]
   */
  public function get_clock_ins($worker_id)
  {
    if (!$this->does_worker_exist($worker_id)) {
      throw new ResourceNotFound($worker_id);
    }

    $clock_ins = Clock::query()
      ->where('worker_id', '=', $worker_id)
      ->where('type', '=', ClockingType::IN->name)
      ->get();

      return $clock_ins;
  }

  /** * Checks whether the passed worker ID exists
   *
   * @param string $worker_id ID of the worker for whom we'd like to check
   *
   * @return boolean
   */
  private function does_worker_exist($worker_id)
  {
    $exists = Worker::query()->select()->where('id', '=', $worker_id)->exists();
    return $exists;
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
  private function calculate_distance($lat1, $lon1, $lat2, $lon2)
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