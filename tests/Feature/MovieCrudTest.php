<?php

use App\Models\Genre;
use App\Models\User;
use Database\Seeders\GenresTableSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

it('can store a movie', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $this->seed(GenresTableSeeder::class);

    $genre1 = Genre::first();
    $genre2 = Genre::skip(1)->first();

    $data = [
        'name' => ['en' => 'Test Movie', 'ka' => 'ტესტი ფილმი'],
        'director' => ['en' => 'John Doe', 'ka' => 'ჯონ დო'],
        'description' => ['en' => 'A test movie description.', 'ka' => 'ტესტი ფილმის აღწერა.'],
        'year' => 2024,
        'genres' => [$genre1->id, $genre2->id],
        'image' => UploadedFile::fake()->image('movie.jpg'),
    ];

    actingAs($user);

    $response = postJson(route('movies.store'), $data)
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Test Movie');

    $movie = $response->json('data');
    expect($movie)->toMatchArray([
        'name' => 'Test Movie',
        'director' => 'John Doe',
        'description' => 'A test movie description.',
        'year' => 2024,
        'media_urls' => ['/storage/1/movie.jpg'],
    ]);
});
