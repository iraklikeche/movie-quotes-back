<?php

use App\Models\Genre;
use App\Models\User;
use Database\Seeders\GenresTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'GenresTableSeeder']);
});

test('a user can store a movie', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    // Get a seeded genre
    $genre = DB::table('genres')->first();

    $data = [
        'name' => [
            'en' => 'Movie Name English',
            'ka' => 'ფილმის სახელი ქართულად'
        ],
        'director' => [
            'en' => 'Director Name English',
            'ka' => 'დირექტორის სახელი ქართულად'
        ],
        'description' => [
            'en' => 'Description in English',
            'ka' => 'აღწერა ქართულად'
        ],
        'year' => 2023,
        'genres' => [$genre->id],
        'image' => UploadedFile::fake()->image('movie.jpg')
    ];

    $response = $this->actingAs($user)->postJson('/api/movies', $data);

    $movieId = $response->json('data.id');

    $response->assertStatus(201)
             ->assertJson([
                 'data' => [
                     'movie_name' => $data['name']['en'],
                     'year' => 2023,
                     'image_url' => Storage::url("$movieId/movie.jpg")
                 ]
             ]);

    $this->assertDatabaseHas('movies', [
        'user_id' => $user->id,
        'year' => 2023,
    ]);

    Storage::disk('public')->assertExists("$movieId/movie.jpg");
});
