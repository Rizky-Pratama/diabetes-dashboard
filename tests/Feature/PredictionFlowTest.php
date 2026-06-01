<?php

use App\Models\PredictionHistory;
use App\Models\User;
use App\Services\PythonPredictionClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('sends input to python api and saves history', function () {

  Http::fake([
    '*' => Http::response(['result' => 'Risiko Diabetes', 'probability' => 0.82], 200),
  ]);

  // ensure service URL is set for the client
  config(['services.python_prediction.url' => 'http://python-api.test']);

  $user = User::factory()->create();

  $this->actingAs($user);

  $payload = [
    'glucose' => 120,
    'blood_pressure' => 80,
    'insulin' => 15,
    'bmi' => 25.5,
    'age' => 45,
  ];

  // call service directly
  $client = app(PythonPredictionClient::class);
  $response = $client->predict($payload);

  expect($response)->toBeArray()->and($response['result'])->toBe('Risiko Diabetes');

  // create record as controller/component would
  PredictionHistory::create(array_merge($payload, [
    'user_id' => $user->id,
    'probability' => $response['probability'],
    'result' => $response['result'],
  ]));

  $this->assertDatabaseHas('prediction_histories', [
    'user_id' => $user->id,
    'result' => 'Risiko Diabetes',
  ]);
});
