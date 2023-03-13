<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class PostClockInResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::object('clock-in')
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
                ])
        );

        return Response::create('PostClockInsResponse')
            ->description('Successfully registered clock-in')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
