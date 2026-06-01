<?php

namespace Database\Factories;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Clinic>
 */
class ClinicFactory extends Factory
{
  protected $model = Clinic::class;

  public function definition(): array
  {
    return [
      'nama_klinik' => $this->faker->company(),
      'logo' => null,
      'alamat' => $this->faker->address(),
      'telepon' => $this->faker->phoneNumber(),
      'email' => $this->faker->companyEmail(),
    ];
  }
}
