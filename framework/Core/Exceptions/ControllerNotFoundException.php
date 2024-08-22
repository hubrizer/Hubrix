<?php
namespace Hubrix\Core\Exceptions;

use Exception;
use ReturnTypeWillChange;

class ControllerNotFoundException extends Exception
{
    /**
     * Customize the exception message and code.
     *
     * @param string $controller The name of the missing controller.
     * @param int $code The error code (optional).
     * @param Exception|null $previous The previous exception (optional).
     */
    public function __construct(string $controller, int $code = 0, Exception $previous = null)
    {
        $message = "The controller class '$controller' does not exist.";
        parent::__construct($message, $code, $previous);
    }

    /**
     * Convert the exception to a string.
     *
     * @return string
     */
    #[ReturnTypeWillChange] public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}