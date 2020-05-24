<?php

namespace JimChen\Trigger\Console;

use Illuminate\Console\Command;
use JimChen\Trigger\Facades\Trigger;

class StatusCommand extends Command
{
    protected $signature = 'trigger:status {--R|replication=default : replication}';
    protected $description = 'Install config and routes';

    public function handle()
    {
        $replication = $this->option('replication');
        $trigger = Trigger::replication($replication);
        $binLogCurrent = $trigger->getCurrent();

        if (is_null($binLogCurrent)) {
            $this->warn('binlog info of ' . $replication . ' is empty.');
        }

        $this->table(
            ['Name', 'Value'],
            [
                ['BinLogPosition', $binLogCurrent->getBinLogPosition()],
                ['BinFileName', $binLogCurrent->getBinFileName()],
                // ['Gtid', $binLogCurrent->getGtid()],
                // ['MariaDbGtid', $binLogCurrent->getMariaDbGtid()],
            ]
        );
    }
}
