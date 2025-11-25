<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeviceRequestService
{
    public function sendRequest()
    {
        $response = Http::get('https://source.coderefinery.org/sdm-edu/wifi2ble-box-simulator/api/devices');

        // Log response
        \Log::info('DeviceRequestService API Response:', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        return $response;
    }
}
