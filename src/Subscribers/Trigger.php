<?php

namespace JimChen\Trigger\Subscribers;

use JimChen\Trigger\EventSubscriber;
use MySQLReplication\Event\DTO\EventDTO;

class Trigger extends EventSubscriber
{
    /**
     * @param EventDTO $event
     */
    protected function allEvents(EventDTO $event): void
    {
        $this->trigger->dispatch($event);
    }
}
