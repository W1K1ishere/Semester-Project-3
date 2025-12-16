<?php

namespace App\Http\Controllers;

use App\Models\OfficeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConditionsController extends Controller
{
    public function view() {
        $dep_names = auth()->user()->departments()->pluck('dep_name');
        $currentConditions = OfficeData::whereIn('department', $dep_names)->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')->from('office_data')->groupBy('department');
        })->orderBy('department')->get();
        return view('auth.condition', [
            'currentConditions' => $currentConditions
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
