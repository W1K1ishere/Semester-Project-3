<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Table;

class SyncDesks extends Command
{
    protected $signature = 'desks:sync';
    protected $description = 'Sync desks from /desks';

    public function handle()
    {
        $response = Http::get('http://127.0.0.1:8080/api/v2/E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7/desks');

        if ($response->failed()) {
            $this->error('Failed to fetch desks.');
            return;
        }

        $desks = $response->json()['desks'] ?? $response->json();

        foreach ($desks as $desk) {
            Table::firstOrCreate(
                ['desk_mac' => $desk],
                [
                    'current_height' => 0,
                    'department_id'  => 1,
                ]
            );
        }

        $this->info('Desks synced.');
    }
}
