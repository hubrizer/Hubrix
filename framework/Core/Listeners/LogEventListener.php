<?php

namespace Hubrix\Core\Listeners;

use Hubrix\Core\Interfaces\EventListenerInterface;
use Hubrix\Core\Interfaces\EventInterface;

/**
 * Class LogEventListener
 *
 * Example listener that logs events.
 *
 * @package Hubrix\Listeners
 */
class LogEventListener implements EventListenerInterface
{
    public function handle(EventInterface $event): void
    {
        my_log("INFO","LogEventListener","Event " . $event->getName() . " triggered with data: " . json_encode($event->getData()));
    }
}