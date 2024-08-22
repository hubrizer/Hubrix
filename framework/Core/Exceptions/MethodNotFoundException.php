<?php
namespace Hubrix\Core\Exceptions;

use Exception;

class MethodNotFoundException extends Exception
{
    /**
     * Customize the exception message and code.
     *
     * @param string $method The name of the missing method.
     * @param int $code The error code (optional).
     * @param \Exception|null $previous The previous exception (optional).
     */
    public function __construct(string $method, int $code = 0, Exception $previous = null)
    {
        $message = "The method '$method' does not exist.";
        parent::__construct($message, $code, $previous);
    }

    /**
     * Convert the exception to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
