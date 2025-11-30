<?php


namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWifi2BleRequestBreak
{
    use Dispatchable, Queueable;

    public function handle()
    {
        Log::info("📡 SendWifi2BleRequestBreak started");

        $apiKey = "E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7"; 
        $baseUrl = "http://127.0.0.1:8080/api/v2/{$apiKey}";

        // get all desks
        $response = Http::timeout(30)->get('http://localhost:8080/api/v2/E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7/desks');


        if (!$response->successful()) {
            Log::error("❌ Failed to fetch desks", ['status' => $response->status()]);
            return;
        }

        $desks = $response->json();
        Log::info("🪑 Desks received", ['count' => count($desks)]);

        // temp standing height
        $standingHeight = 1100; 

        //  loop through desks and send put requests
foreach ($desks as $desk) {
    $deskId = $desk; 

    Log::info(" Processing desk", ['desk' => $deskId]);

    $put = Http::put("$baseUrl/desks/$deskId/state", [
        "position_mm" => 900 // standing height
    ]);

    if ($put->successful()) {
        Log::info("🟢 Desk raised", ['desk' => $deskId, 'response' => $put->body()]);
    } else {
        Log::error("❌ Failed to raise desk", [
            'desk' => $deskId,
            'status' => $put->status(),
            'body' => $put->body()
        ]);
    }
}


    }
}
