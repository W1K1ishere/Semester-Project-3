<?php

namespace App\Console\Commands;

use App\Models\OfficeData;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class Listener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mqtt::connection()->subscribe('pico-measurements', function (string $topic, string $message) {
            $data = json_decode($message, true);

            OfficeData::create([
                'department' => $data['device'] ?? 'error',
                'temperature' => $data['temperature'] ?? 0,
                'humidity' => $data['humidity'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        Mqtt::connection()->loop(true);
    }
}
