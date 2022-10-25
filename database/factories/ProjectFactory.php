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
    public function definition()
    {
        return [
            'title'=>'Moderne Website Portfolio',
            'description'=>'Website adaptable for all devices',
            'link'=>'https://github.com/abdelrhmanMohmaed/My-Portfolio',
            'photo'=>'avatar.png',
        ];
    }
}
