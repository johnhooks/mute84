<?php

namespace App\Exceptions\RestApi;

use Throwable;
use Illuminate\Http\Response;

class NotImplementedException extends RestApiException
{
    /**
     * @inheritDoc
     */
    public function __construct(
        string $errorCode = 'rest_api.not_implemented',
        int $httpCode = Response::HTTP_NOT_IMPLEMENTED,
        Throwable $previous = null,
        ?string $errorMessage = null,
    ) {
        parent::__construct($errorCode, $httpCode, $previous, $errorMessage);
    }
}
