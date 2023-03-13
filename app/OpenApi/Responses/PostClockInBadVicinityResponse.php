<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class PostClockInBadVicinityResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('error')->example('You must be in the vicinity of the workplace'),
        );

        return Response::create('PostClockInBadVicinityResponse')
            ->statusCode(400)
            ->description('Validation error')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
