<?php

namespace JimChen\Trigger\Facades;

use Illuminate\Support\Facades\Facade;
use MySQLReplication\BinLog\BinLogCurrent;
use MySQLReplication\Config\Config;
use MySQLReplication\Event\DTO\EventDTO;

/**
 * @see \JimChen\Trigger\Manager
 * @method static \JimChen\Trigger\Trigger replication(?string $name = null)
 * @method static array replications()
 * @see \JimChen\Trigger\Trigger
 * @method static Config configure()
 * @method static array getConfig()
 * @method static array getSubscribers()
 * @method static void loadRoutes()
 * @method static void start()
 * @method static void terminate()
 * @method static boolean isTerminated()
 * @method static void heartbeat(EventDTO $event)
 * @method static void rememberCurrent(BinLogCurrent $binLogCurrent)
 * @method static BinLogCurrent getCurrent()
 * @method static void clearCurrent()
 * @method static void on(string $table, $eventType, $action = null)
 * @method static void dispatch(EventDTO $event)
 * @method static void fire($events, EventDTO $event = null)
 * @method static array getEvents()
 */
class Trigger extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'trigger.manager';
    }
}
