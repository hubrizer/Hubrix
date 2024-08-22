<?php


namespace Hubrix\Core;

/**
 * Class FrameworkException
 *
 * A base exception class for the Hubrix framework.
 * This class can be extended to create custom exceptions within the framework.
 *
 * @package Hubrix\Core
 */
class Exception extends \Exception
{
    /**
     * Additional data for the exception
     *
     * @var array
     */
    protected array $data = [];

    /**
     * FrameworkException constructor.
     *
     * @param string $message The exception message.
     * @param int $code The exception code.
     * @param \Throwable|null $previous The previous exception used for the exception chaining.
     * @param array $data Additional data to attach to the exception.
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null, array $data = [])
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    /**
     * Get additional data attached to the exception.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Return the exception message with additional data (if any).
     *
     * @return string
     */
    public function getFullMessage(): string
    {
        $fullMessage = $this->getMessage();

        if (!empty($this->data)) {
            $fullMessage .= ' | Data: ' . json_encode($this->data);
        }

        return $fullMessage;
    }

    /**
     * Convert the exception to a string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            "[%s]: %s in %s on line %d\n",
            get_class($this),
            $this->getFullMessage(),
            $this->getFile(),
            $this->getLine()
        );
    }
}
