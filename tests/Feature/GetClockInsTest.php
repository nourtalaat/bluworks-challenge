<?php

namespace Tests\Feature;

use App\Enum\Clock\ClockingType;
use App\Models\Clock;
use App\Models\Worker;
use Tests\TestCase;

class GetClockInsTest extends TestCase
{
    /**
     * I believe these are not very useful given that the
     * function name is very explicit and self explanatory
     */
    public function test_the_application_returns_400_if_worker_id_is_missing(): void
    {
        $response = $this->get('/worker/clock-ins');

        $response->assertStatus(400);
        $response->assertContent('{"error":"Invalid request"}');
    }

    public function test_the_application_returns_404_if_worker_is_not_found(): void
    {
        $worker_id = 456;
        $response = $this->get("/worker/clock-ins?worker_id=$worker_id");

        $response->assertStatus(404);
        $response->assertContent('{"error":"Worker not found"}');
    }

    public function test_the_application_returns_an_empty_list_of_clock_ins_for_the_worker(): void
    {
        $worker_id = Worker::create()->id;
        $response = $this->get("/worker/clock-ins?worker_id=$worker_id");

        $response->assertStatus(200);
        $response->assertContent('{"clock_ins":[]}');
    }

    public function test_the_application_returns_array_of_clock_ins_for_the_worker(): void
    {
        $worker_id = Worker::create()->id;
        $timestamp = time();
        $longitude = 30;
        $latitude = 30;

        $clock_in = Clock::create(
            array(
                'worker_id' => $worker_id,
                'timestamp' => $timestamp,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'type' => ClockingType::IN->name,
            )
        );
        
        // Figure out why this is happening
        $clock_in->type = ClockingType::IN->name;

        $response = $this->get("/worker/clock-ins?worker_id=$worker_id");

        $response->assertStatus(200);
        $clock_ins_expected_response = json_encode(
            array(
                "clock_ins" => array($clock_in)
            )
        );
        $clock_ins_actual_response = $response->content();
        $this->assertJsonStringEqualsJsonString($clock_ins_expected_response, $clock_ins_actual_response);
    }
}