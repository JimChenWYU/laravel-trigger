<?php

namespace Huangdijia\Trigger\Console;

use Huangdijia\Trigger\BinLogBootstrap;
use Illuminate\Console\Command;
use MySQLReplication\Config\ConfigBuilder;
use MySQLReplication\Event\EventSubscribers;
use MySQLReplication\Exception\MySQLReplicationException;
use MySQLReplication\MySQLReplicationFactory;

class StartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trigger:start';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start trigger service"';
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        start:
        try {
            // 信息打印
            $this->info(sprintf(
                "Host:%s\nPort:%s\nUser:%s\nPassword:%s\n",
                config('trigger.host', ''),
                config('trigger.port', ''),
                config('trigger.user', ''),
                config('trigger.password', '')
            ));

            // 实例化
            $binLogStream = new MySQLReplicationFactory(
                BinLogBootstrap::startFromPosition(new ConfigBuilder(), $this)
                    ->withSlaveId(time())
                    ->withHost(config('trigger.host', ''))
                    ->withPort(config('trigger.port', ''))
                    ->withUser(config('trigger.user', ''))
                    ->withPassword(config('trigger.password', ''))
                    ->withDatabasesOnly(config('trigger.databases', []))
                    ->withTablesOnly(config('trigger.tables', []))
                    ->withHeartbeatPeriod(config('trigger.heartbeat', 3))
                    ->build()
            );

            // 事件自动发现 & 注册
            collect(glob(app()->path() . '/Events/*.php'))
                ->mapWithKeys(function ($path) {
                    $class = str_replace(app()->path(), 'App', pathinfo($path, PATHINFO_DIRNAME)) . '/' . pathinfo($path, PATHINFO_FILENAME);
                    $class = strtr($class, '/', '\\');

                    return [$path => $class];
                })
                ->reject(function ($class) {
                    return !is_subclass_of($class, EventSubscribers::class);
                })
                ->each(function ($class) use ($binLogStream) {
                    $binLogStream->registerSubscriber(app($class));
                    $this->info("Subscriber {$class} registered");
                });

            // 执行
            $this->info("\nTrigger running");
            $binLogStream->run();
        } catch (MySQLReplicationException $e) {
            // 输出错误
            $this->error($e->getMessage());

            // 清理缓存
            BinLogBootstrap::clear();

            // 重试
            $this->info('Retry now');
            goto start;
        }
    }
}