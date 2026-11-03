<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Override;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    #[Override]
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'url' => fake()->url(),
            'excerpt' => fake()->text(),
            'description' => fake()->text(),
            'on_carreer_page' => fake()->boolean(),
            'in_logo_bar' => fake()->boolean(),
            'membercard_excerpt' => fake()->text(),
            'membercard_long' => fake()->text(),
            'on_membercard' => fake()->boolean(),
            'sort' => Company::query()->max('sort') + 1,
        ];
    }
}
