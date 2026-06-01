<?php

namespace Database\Factories;

use App\Models\PredictionHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PredictionHistory>
 */
class PredictionHistoryFactory extends Factory
{
  protected $model = PredictionHistory::class;

  public function definition(): array
  {
    return [
      'clinic_id' => null,
      'user_id' => null,
      'glucose' => $this->faker->randomFloat(2, 50, 200),
      'blood_pressure' => $this->faker->randomFloat(2, 60, 140),
      'insulin' => $this->faker->randomFloat(2, 2, 30),
      'bmi' => $this->faker->randomFloat(2, 15, 40),
      'age' => $this->faker->numberBetween(18, 80),
      'probability' => $this->faker->randomFloat(4, 0, 1),
      'result' => $this->faker->randomElement(['Risiko Diabetes', 'Tidak Berisiko']),
    ];
  }
}
