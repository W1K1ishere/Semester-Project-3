<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use App\Models\SensorReading;
use Illuminate\Support\Facades\Log;

class MqttSubscriberService
{
    protected $client = null;
    protected string $brokerHost;
    protected int $brokerPort;
    protected string $topic;

    public function __construct()
    {
        $this->brokerHost = config('mqtt.broker_host');
        $this->brokerPort = config('mqtt.broker_port');
        $this->topic      = config('mqtt.topic');
    }

    
    
    public function connectAndSubscribe(): void
    {
        // Check if MQTT client library is available
        if (!class_exists(\PhpMqtt\Client\MqttClient::class)) {
            throw new \RuntimeException(
                'MQTT client library not found. ' .
                'Install with: composer require php-mqtt/client'
            );
        }
        try {
            $this->client = new \PhpMqtt\Client\MqttClient(
                $this->brokerHost,
                $this->brokerPort,
                'tabely_subscriber_' . uniqid(),
                \PhpMqtt\Client\MqttClient::MQTT_3_1_1
            );
            $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
                ->setKeepAliveInterval(60)
                ->setLastWillTopic('sensors/status')
                ->setLastWillMessage('disconnected')
                ->setLastWillQualityOfService(1);
            $this->client->connect($connectionSettings, true);
            Log::info('✅ MQTT connected', [
                'broker' => "{$this->brokerHost}:{$this->brokerPort}",
                'topic' => $this->topic
            ]);
            $this->client->subscribe($this->topic, function (string $topic, string $message) {
                echo "MESSAGE RECEIVED on {$topic}: {$message}\n";  
                $this->handleMessage($topic, $message);
            }, \PhpMqtt\Client\MqttClient::QOS_AT_LEAST_ONCE);
            Log::info("📡 Subscribed to topic: {$this->topic}");
        } catch (\Exception $e) {
            Log::error('❌ MQTT connection failed', [
                'error' => $e->getMessage(),
                'broker' => "{$this->brokerHost}:{$this->brokerPort}"
            ]);
            dd("MQTT CONNECTION FAILED: " . $e->getMessage());
        }
    }
    public function handleMessage(string $topic, string $message): void
{
    try {
        $data = json_decode($message, true);

        if (!isset($data['temp']) || !isset($data['hum'])) {
            Log::warning('⚠️ Invalid sensor data format', ['message' => $message]);
            return;
        }

        SensorReading::create([
            'sensor_id'   => (config('mqtt.client_id', 'pico_sensor_1')),
            'temperature' => ($data['temp']),
            'humidity'    => ($data['hum']),
            'topic'       => ($topic),
        ]);

        Log::info('📊 Sensor reading saved', [
            'temp'  => $data['temp'],
            'hum'   => $data['hum'],
            'topic' => $topic
        ]);

    } catch (\Exception $e) {
        Log::error('❌ Error processing sensor data', [
            'error' => $e->getMessage(),
            'message' => $message
        ]);
    }
}

    
    public function listen(): void
{
    echo "LISTEN LOOP START\n";
    if (!$this->client) {
        throw new \RuntimeException('MQTT client not connected.');
    }
    try {
        // THIS IS WHAT LISTENS FOR MQTT MESSAGES
        $this->client->loop(true);
    } catch (\Exception $e) {
        Log::error('❌ MQTT listener error', ['error' => $e->getMessage()]);
        throw $e;
    }
}
    /**
     * Disconnect from MQTT broker
     */
    public function disconnect(): void
    {
        if ($this->client) {
            $this->client->disconnect();
            Log::info('🔌 MQTT disconnected');
        }
    }
    public function processSensorReading(array $data, string $topic = null): void
    {
        $this->handleMessage($topic ?? $this->topic, json_encode($data));
    }
}

