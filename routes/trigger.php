<?php
/** @var Trigger $trigger */

use JimChen\Trigger\Trigger;

$trigger->on('*', 'heartbeat', function ($event) use ($trigger) {
    $trigger->heartbeat($event);
});
