<?php

namespace Tests\Feature;

use Tests\TestCase;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MqttTest extends TestCase
{
    use RefreshDatabase;

    public function test_fake_pico_message()
    {
        MQTT::connection()->publish(
            'pico-measurements',
            json_encode([
                'device' => 'test',
                'temperature' => 24.5,
                'humidity' => 50,
            ]),
            0
        );

        $found = false;
        for ($i = 0; $i < 20; $i++) {
            if (\DB::table('office_data')
                ->where('department', 'test')
                ->where('temperature', 24.5)
                ->where('humidity', 50)
                ->exists()) {
                $found = true;
                break;
            }
            usleep(150_000);
        }

        $this->assertTrue($found);
    }
}
