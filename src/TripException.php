<?php

namespace App;

use RuntimeException;
use Throwable;

class TripException extends RuntimeException
{
    /**
     * WebsiteException constructor.
     *
     * @param $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
