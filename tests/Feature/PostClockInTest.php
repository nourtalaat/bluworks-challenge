<?php

namespace Tests\Feature;

use App\Models\Worker;
use Tests\TestCase;

class PostClockInTest extends TestCase
{
    public function test_the_application_returns_400_if_worker_id_is_missing(): void
    {
        $response = $this->post('/worker/clock-in');

        $response->assertStatus(400);
        $response->assertContent('{"error":"Invalid request"}');
    }

    public function test_the_application_returns_404_if_worker_not_found(): void
    {
        $response = $this->post('/worker/clock-in', array(
            'worker_id' => '456',
            'timestamp' => time(),
            'latitude' => 30,
            'longitude' => 30,
        ));

        $response->assertStatus(404);
        $response->assertContent('{"error":"Worker not found"}');
    }

    public function test_the_application_returns_400_if_distance_gt_max_distance(): void
    {
        $worker = Worker::create();
        $response = $this->post('/worker/clock-in', array(
            'worker_id' => "$worker->id",
            'timestamp' => time(),
            'latitude' => 20,
            'longitude' => 20,
        ));

        $response->assertStatus(400);
        $response->assertContent('{"error":"You must be in the vicinity of the workplace"}');
    }

    public function test_the_application_returns_400_if_timestamp_unacceptable(): void
    {
        $worker = Worker::create();
        $response = $this->post('/worker/clock-in', array(
            'worker_id' => "$worker->id",
            'timestamp' => time()-70,
            'latitude' => 20,
            'longitude' => 20,
        ));

        $response->assertStatus(400);
        $response->assertContent('{"error":"Invalid request"}');
    }

    public function test_the_application_creates_clock_in_returns_it(): void
    {
        $worker = Worker::create();
        $response = $this->post('/worker/clock-in', array(
            'worker_id' => "$worker->id",
            'timestamp' => time(),
            'latitude' => 30.04,
            'longitude' => 31.24,
        ));

        $response->assertStatus(201);
    }
}
