<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeskController extends Controller
{
    public function index()
    {
        try {
            $apiKey = config('E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7'); // or hardcode while testing
            $base = config('http://localhost:8080/api/v2');  // e.g. http://localhost:8080/api/v2
            $url = "{$base}/{$apiKey}/desks";

            // add timeout and proper error handling
            $res = Http::timeout(10)->get($url);

            if ($res->successful()) {
                return response()->json($res->json());
            }

            Log::error('Failed to fetch desks', ['status' => $res->status(), 'body' => $res->body()]);
            return response()->json(['error' => 'Failed to fetch desks'], 500);

        } catch (\Throwable $e) {
            Log::error('Exception fetching desks', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Exception fetching desks'], 500);
        }
    }
}
