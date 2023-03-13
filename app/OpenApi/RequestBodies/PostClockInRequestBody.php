<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\PostClockInSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class PostClockInRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('PostClockIn')
        ->description('Clock-in details')
        ->content(
            MediaType::json()->schema(PostClockInSchema::ref())
        );    }
}

