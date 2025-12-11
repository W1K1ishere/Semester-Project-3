<?php

namespace App\Console\Commands;

use App\Services\MqttSubscriberService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MqttSubscribeCommand extends Command
{
    protected $signature = 'mqtt:subscribe 
                            {--daemon : Run as daemon/background process}';
    protected $description = 'Subscribe to MQTT broker and store sensor readings in database';
    protected MqttSubscriberService $subscriber;
    public function __construct(MqttSubscriberService $subscriber)
    {
        parent::__construct();
        $this->subscriber = $subscriber;
    }
    public function handle(): int
{
    $this->info("STEP 1: Command started");
    try {
        $this->subscriber->connectAndSubscribe();
        $this->info("STEP 2: connectAndSubscribe finished");
        $this->info('📡 Listening for messages...');
        $this->info('Press Ctrl+C to stop');
        $this->subscriber->listen();
        $this->info("STEP 3: listen() finished");
    } catch (\Exception $e) {
        $this->error('❌ Error: ' . $e->getMessage());
        return Command::FAILURE;
    }
    return Command::SUCCESS;
}
}