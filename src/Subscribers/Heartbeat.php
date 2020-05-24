<?php

namespace JimChen\Trigger\Subscribers;

use JimChen\Trigger\EventSubscriber;
use MySQLReplication\Event\DTO\HeartbeatDTO;

class Heartbeat extends EventSubscriber
{
    public function onHeartbeat(HeartbeatDTO $event): void
    {
        $this->trigger->heartbeat($event);
    }
}
