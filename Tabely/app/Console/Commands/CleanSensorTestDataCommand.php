<?php

namespace App\Console\Commands;

use App\Models\SensorReading;
use Illuminate\Console\Command;

class CleanSensorTestDataCommand extends Command
{
    protected $signature = 'sensor:clean-test-data 
                            {--sensor-id= : Clean data from specific sensor ID}
                            {--all : Remove all sensor readings}
                            {--confirm : Skip confirmation prompt}';
    
    protected $description = 'Remove test data from sensor_readings table';

    public function handle(): int
    {
        $sensorId = $this->option('sensor-id');
        $all = $this->option('all');

        if ($all) {
            $count = SensorReading::count();
            
            if ($count === 0) {
                $this->info('✅ No sensor readings found in database.');
                return Command::SUCCESS;
            }

            if (!$this->option('confirm')) {
                if (!$this->confirm("⚠️  This will delete ALL {$count} sensor readings. Continue?")) {
                    $this->info('❌ Operation cancelled.');
                    return Command::FAILURE;
                }
            }

            SensorReading::truncate();
            $this->info("✅ Deleted all {$count} sensor readings from database.");
            
        } elseif ($sensorId) {
            $count = SensorReading::where('sensor_id', $sensorId)->count();
            
            if ($count === 0) {
                $this->info("✅ No readings found for sensor ID: {$sensorId}");
                return Command::SUCCESS;
            }

            if (!$this->option('confirm')) {
                if (!$this->confirm("⚠️  This will delete {$count} readings for sensor '{$sensorId}'. Continue?")) {
                    $this->info('❌ Operation cancelled.');
                    return Command::FAILURE;
                }
            }

            SensorReading::where('sensor_id', $sensorId)->delete();
            $this->info("✅ Deleted {$count} readings for sensor ID: {$sensorId}");
            
        } else {
            // Show summary and let user choose
            $total = SensorReading::count();
            
            if ($total === 0) {
                $this->info('✅ No sensor readings found in database.');
                return Command::SUCCESS;
            }

            $this->info("📊 Found {$total} sensor readings in database.");
            $this->newLine();  
            $sensors = SensorReading::select('sensor_id')
                ->distinct()
                ->pluck('sensor_id');        
            $this->table(
                ['Sensor ID', 'Count'],
                $sensors->map(function ($id) {
                    return [
                        $id,
                        SensorReading::where('sensor_id', $id)->count()
                    ];
                })->toArray()
            );
            $this->newLine();
            $this->warn('Use one of these options:');
            $this->line('  php artisan sensor:clean-test-data --sensor-id=<id>');
            $this->line('  php artisan sensor:clean-test-data --all');
        }
        return Command::SUCCESS;
    }
}






