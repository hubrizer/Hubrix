<?php

namespace Hubrix\Core\Interfaces;

/**
 * Interface EventListenerInterface
 *
 * This interface defines the contract for event listeners.
 *
 * @package Hubrix\Core\Interfaces
 */
interface EventListenerInterface
{
    /**
     * Handle the event.
     *
     * @param EventInterface $event
     * @return void
     */
    public function handle(EventInterface $event): void;
}
