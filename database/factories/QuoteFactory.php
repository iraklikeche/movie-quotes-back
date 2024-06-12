<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Faker\Factory as GeorgianFactory;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'movie_id' => Movie::factory(),
            'content' => [
                'en' => $this->faker->sentence(),
                'ka' => GeorgianFactory::create('ka_GE')->realText(30),
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Quote $quote) {
            $image = UploadedFile::fake()->image('quote.jpg');
            $quote->addMedia($image)->toMediaCollection('images');
        });
    }
}
