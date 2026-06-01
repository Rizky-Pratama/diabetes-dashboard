<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PythonPredictionClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.python_prediction.url') ?? env('PYTHON_API_URL');
    }

    /**
     * Send input data to Python API and return decoded JSON.
     */
    public function predict(array $payload): ?array
    {
        if (empty($this->baseUrl)) {
            return null;
        }

        $response = Http::timeout(10)->post(rtrim($this->baseUrl, '/') . '/predict', $payload);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
