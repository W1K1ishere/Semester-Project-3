<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class WiFi2BleSimulatorService
{
    protected string $baseUrl;

    public function __construct()
    {
        // configure this in your .env
        $this->baseUrl = config('services.simulator.base_url');
    }

    /**
     * Fetch all desks from the simulator.
     *
     * @return array|null
     */
    public function getDesks(): ?array
    {
        $response = Http::get("{$this->baseUrl}/desks");

        if ($response->ok()) {
            return $response->json();
        }

        \Log::error('WiFi2BLE: Failed to fetch desks', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }

    /**
     * Set the height for a single desk.
     *
     * @param  int|string  $deskId
     * @param  int         $height
     * @return \Illuminate\Http\Client\Response
     */
    public function setDeskHeight($deskId, int $height)
    {
        $url = "{$this->baseUrl}/desks/{$deskId}/state";

        $response = Http::post($url, [
            'height' => $height,
        ]);

        if (!$response->successful()) {
            \Log::error('WiFi2BLE: Failed to set height', [
                'deskId' => $deskId,
                'height' => $height,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }

        return $response;
    }

    /**
     * Set height for multiple desks.
     *
     * @param  array       $deskIds
     * @param  int         $height
     * @return void
     */
    public function setMultipleDeskHeights(array $deskIds, int $height)
    {
        foreach ($deskIds as $id) {
            $this->setDeskHeight($id, $height);
        }
    }
}
