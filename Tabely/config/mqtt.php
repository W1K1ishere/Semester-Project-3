<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MQTT Broker Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for connecting to the MQTT broker that receives
    | sensor data from Picobrick devices.
    |
    */

    'broker_host' => env('MQTT_BROKER_HOST', '127.0.0.1'),
    'broker_port' => env('MQTT_BROKER_PORT', 1883),
    'topic'       => env('MQTT_TOPIC', 'sensors/dht'),
    'client_id'   => env('MQTT_CLIENT_ID', 'laravel_subscriber_1'),
    
    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    */
    'keep_alive' => env('MQTT_KEEP_ALIVE', 60),
    'timeout' => env('MQTT_TIMEOUT', 30),
];

