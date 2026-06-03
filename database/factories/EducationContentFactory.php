<?php

namespace Database\Factories;

use App\Models\EducationContent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EducationContent>
 */
class EducationContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'result_type' => $this->faker->randomElement(EducationContent::RESULT_TYPES),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
