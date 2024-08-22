<?php

namespace Hubrix\Core\Interfaces;

/**
 * Interface EventInterface
 *
 * This interface defines the contract for events in the Hubrix framework.
 *
 * @package Hubrix\Core\Interfaces
 */
interface EventInterface
{
    /**
     * Get the name of the event.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the data associated with the event.
     *
     * @return array
     */
    public function getData(): array;
}
