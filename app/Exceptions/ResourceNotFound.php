<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFound extends Exception
{
    private readonly string $resource_id;

    function __construct($resource_id) {
        $this->resource_id = $resource_id;
    }
    
    /**
     * Get the exception's context information.
     *
     * @return array<string, mixed>
     */
    public function context(): array
    {
        return ['resource_id' => $this->resource_id];
    }
}
