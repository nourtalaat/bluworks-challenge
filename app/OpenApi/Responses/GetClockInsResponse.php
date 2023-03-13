<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class GetClockInsResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::object('clock-ins')
                ->additionalProperties(
                    Schema::array()->items(Schema::string())
                )
                ->example([
                    [
                        'id' => '1',
                        'worker_id' => '123',
                        'timestamp' => 1678220445,
                        'longitude' => 31.24,
                        'latitude' => 30.03,
                        'type' => 'IN',
                        'created_at' => '2023-03-07T20:20:55.000000Z',
                        'updated_at' => '2023-03-07T20:20:55.000000Z',
                    ],
                    [
                        'id' => '2',
                        'worker_id' => '123',
                        'timestamp' => 1678330421,
                        'longitude' => 30.24,
                        'latitude' => 31.03,
                        'type' => 'IN',
                        'created_at' => '2023-03-08T17:07:55.000000Z',
                        'updated_at' => '2023-03-08T17:07:55.000000Z',
                    ]
                ])
        );

        return Response::create('GetClockInsResponse')
            ->description('Successfully fetched clock-ins')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}