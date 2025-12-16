<?php

namespace App\Http\Controllers;

use App\Models\OfficeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ConditionsController extends Controller
{
    public function view() {
        $dep_names = auth()->user()->departments()->pluck('dep_name');

        $currentConditions = OfficeData::whereIn('department', $dep_names)->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')->from('office_data')->groupBy('department');
            })->orderBy('department')->get();

        $humidityData = OfficeData::whereIn('department', $dep_names)->where('created_at', '>=', now()->subDays(7))->selectRaw('DATE(created_at) as day, department, AVG(humidity) as avg_humidity')->groupBy('day', 'department')->orderBy('day')->get();

        $temperatureData = OfficeData::whereIn('department', $dep_names)->where('created_at', '>=', now()->subDays(7))->selectRaw('DATE(created_at) as day, department, AVG(temperature) as avg_temperature')->groupBy('day', 'department')->orderBy('day')->get();

        $days = $humidityData->pluck('day')->merge($temperatureData->pluck('day'))->unique()->values();

        $humidityDatasets = [];
        $temperatureDatasets = [];

        foreach ($dep_names as $department) {
            $humidityDatasets[] = [
                'label' => $department,
                'data' => $days->map(function ($day) use ($humidityData, $department) {
                    $row = $humidityData->where('day', $day)->where('department', $department)->first();
                    return $row ? round($row->avg_humidity, 1) : null;
                }),
            ];

            $temperatureDatasets[] = [
                'label' => $department,
                'data' => $days->map(function ($day) use ($temperatureData, $department) {
                    $row = $temperatureData->where('day', $day)->where('department', $department)->first();
                    return $row ? round($row->avg_temperature, 1) : null;
                }),
            ];
        }

        return view('auth.condition', [
            'currentConditions' => $currentConditions,
            'humidityDatasets' => $humidityDatasets,
            'temperatureDatasets' => $temperatureDatasets,
            'days' => $days,
        ]);
    }

    public function fetchWeather(Request $request) {
        $request->validate([
           'lat' => 'required|numeric',
           'lon' => 'required|numeric',
        ]);

        $fetchedData = Http::get(
          'https://api.openweathermap.org/data/2.5/weather',
            [
                'lat' => $request->lat,
                'lon' => $request->lon,
                'units' => 'metric',
                'appid' => config('services.openweather.key'),
            ]
        );

        return response()->json($fetchedData->json());
    }
}
