<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

use Faker\Factory as GeorgianFactory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {

        return [
            'user_id' => User::factory(),
            'name' => [
                'en' => $this->faker->sentence(),
                'ka' => GeorgianFactory::create('ka_GE')->realText(15),
            ],
            'director' => [
                'en' => $this->faker->name,
                'ka' =>  GeorgianFactory::create('ka_GE')->name,
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'ka' =>  GeorgianFactory::create('ka_GE')->realText(30),
            ],
            'year' => $this->faker->year,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Movie $movie) {
            $image = UploadedFile::fake()->image('movie.jpg');
            $movie->addMedia($image)->toMediaCollection('movies');
        });
    }
}
