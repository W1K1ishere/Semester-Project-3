<?php

namespace App\Http\Controllers;

use App\Models\OfficeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConditionsController extends Controller
{
    public function view() {
        $currentCondition = OfficeData::latest()->first();
        return view('auth.condition',[
            'currentCondition' => $currentCondition
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
