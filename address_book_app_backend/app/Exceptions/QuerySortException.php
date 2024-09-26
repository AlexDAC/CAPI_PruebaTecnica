<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Exception;

class QuerySortException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render()
    {
        return ApiResponse::unprocessable(null, null,'Sort column not found. The query could not be sorted by the given sortBy parameter.');
    }
}
