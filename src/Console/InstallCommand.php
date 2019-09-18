<?php

namespace Huangdijia\Trigger\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature   = 'trigger:install {--force}';
    protected $description = 'Install config and routes';

    public function handle()
    {
        $force = $this->option('force');

        collect([
            __DIR__ . '/../../config/trigger.php' => app()->basePath('config/trigger.php'),
            __DIR__ . '/../../routes/trigger.php' => app()->basePath('routes/trigger.php'),
        ])
            ->reject(function ($target, $source) use ($force) {
                if (!$force && file_exists($target)) {
                    $this->warn("{$target} already exists!");
                    return true;
                }

                return false;
            })
            ->each(function ($target, $source) {
                file_put_contents($target, file_get_contents($source));
                $this->info($target . ' installed successfully.');
            });
    }
}
