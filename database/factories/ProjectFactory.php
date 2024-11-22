<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectNo = rand(0, 100);

        return [
            'name' => "Project {$projectNo}",
            'description' => "This is Project {$projectNo}",
            'user_id' => '1',
            'type' => 'dev media'

        ];
    }
}
