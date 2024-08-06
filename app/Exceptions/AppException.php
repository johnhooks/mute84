<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Response;

/**
 * class AppException
 */
class AppException extends Exception
{
    /**
     * The user-friendly error message.
     */
    protected string $errorMessage;

    /**
     * @param string          $errorCode    The application string error code.
     * @param int             $httpCode     The HTTP numeric error code.
     * @param Throwable|null  $previous     The previous throwable used for the exception chaining.
     * @param null|string     $errorMessage The user-friendly error message.
     *
     * @return void
     */
    public function __construct(
        string $errorCode = 'app.unknown_error',
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null,
        ?string $errorMessage = null,
    ) {
        parent::__construct($errorCode, $httpCode, $previous);

        $this->errorMessage = $errorMessage ?? __('An unknown error occurred.');
    }

    /**
     * Gets the application error code.
     *
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->message;
    }

    /**
     * Gets the HTTP error code.
     *
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->code;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
