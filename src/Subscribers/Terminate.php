<?php

namespace JimChen\Trigger\Subscribers;

use JimChen\Trigger\EventSubscriber;
use MySQLReplication\Event\DTO\EventDTO;

class Terminate extends EventSubscriber
{
    /**
     * @param EventDTO $event
     */
    protected function allEvents(EventDTO $event): void
    {
        if ($this->trigger->isReseted()) {
            $this->trigger->clearCurrent();
        }

        if ($this->trigger->isTerminated()) {
            die('Terminated');
        }
    }
}
