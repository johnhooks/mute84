<?php

namespace App\Exceptions\RestApi;

use Throwable;
use App\Exceptions\AppException;
use Illuminate\Http\Response;

class RestApiException extends AppException
{
    /**
     * @inheritDoc
     */
    public function __construct(
        string $errorCode = 'rest_api.unknown_error',
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null,
        ?string $errorMessage = null,
    ) {
        parent::__construct($errorCode, $httpCode, $previous, $errorMessage);
    }
}
