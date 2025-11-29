<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWifi2BleRequestJob
{
    use Dispatchable, Queueable;

    protected $tableId;
    protected $heightMM;

    public function __construct($tableId, $heightMM)
    {
        $this->tableId = $tableId;
        $this->heightMM = $heightMM; 
    }

    public function handle()
    {
        Log::info("📡 SendWifi2BleRequestJob started", [
            'table_id' => $this->tableId,
            'desired_position_mm' => $this->heightMM
        ]);

        $apiKey = "E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7";
        $baseUrl = "http://127.0.0.1:8080/api/v2/{$apiKey}";

  
        $desk = \DB::table('tables')->where('id', $this->tableId)->first();

        if (!$desk) {
            Log::error("❌ Table not found", ['table_id' => $this->tableId]);
            return;
        }

        if (!$desk->desk_mac) {
            Log::error("❌ No desk_mac assigned", ['table_id' => $this->tableId]);
            return;
        }

        $url = "{$baseUrl}/desks/{$desk->desk_mac}/state";

        Log::info("📤 PUT Request", [
            'url' => $url,
            'position_mm' => $this->heightMM
        ]);

        $response = Http::timeout(30)->put($url, [
            "position_mm" => $this->heightMM
        ]);

        if ($response->successful()) {

            Log::info("🟢 Desk movement command accepted", [
                'desk_mac' => $desk->desk_mac,
                'response' => $response->json()
            ]);

        } else {
            Log::error("❌ Desk failed to raise", [
                'desk_mac' => $desk->desk_mac,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }
    }
}
