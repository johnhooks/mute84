<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;

class NotImplementedException extends AppException
{
    /**
     * @inheritDoc
     */
    public function __construct(
        string $errorCode = 'app.not_implemented',
        int $httpCode = Response::HTTP_NOT_IMPLEMENTED,
        Throwable $previous = null,
        ?string $errorMessage = null,
    ) {
        parent::__construct($errorCode, $httpCode, $previous, $errorMessage);
    }
}
